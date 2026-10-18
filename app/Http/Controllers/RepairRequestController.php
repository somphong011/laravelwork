<?php

namespace App\Http\Controllers;

use App\Models\RepairRequest;
use App\Models\Category;
use App\Models\User;
use App\Enums\RepairStatus;
use App\Enums\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class RepairRequestController extends Controller
{
    // หน้าแสดงรายการแจ้งซ่อม + สรุปสถิติ + ตัวกรอง
    public function index(Request $request)
    {
        $user = Auth::user();
        $tradesmen = [];
        $categories = Category::all();

        // 1. ดึง Query พื้นฐานตามสิทธิ์ (Role)
        $query = RepairRequest::with(['user', 'category', 'tradesman']);

        if ($user->isAdmin()) {
            $tradesmen = User::where('role', UserRole::TRADESMAN)->get();

            if ($request->filled('tradesman_id')) {
                $query->where('tradesman_id', $request->tradesman_id);
            }

            $stats = [
                'total'       => RepairRequest::count(),
                'pending'     => RepairRequest::where('status', RepairStatus::PENDING)->count(),
                'assigned'    => RepairRequest::where('status', RepairStatus::ASSIGNED)->count(),
                'in_progress' => RepairRequest::where('status', RepairStatus::IN_PROGRESS)->count(),
                'completed'   => RepairRequest::where('status', RepairStatus::COMPLETED)->count(),
            ];
        } elseif ($user->isTradesman()) {
            $viewMode = $request->get('tab', 'my_jobs'); // 'my_jobs' or 'pool'

            if ($viewMode === 'pool') {
                $query->whereNull('tradesman_id')->where('status', RepairStatus::PENDING);
            } else {
                $query->where('tradesman_id', $user->id);
            }

            $myJobs = RepairRequest::where('tradesman_id', $user->id);
            $stats = [
                'my_total'    => (clone $myJobs)->count(),
                'assigned'    => (clone $myJobs)->where('status', RepairStatus::ASSIGNED)->count(),
                'in_progress' => (clone $myJobs)->where('status', RepairStatus::IN_PROGRESS)->count(),
                'completed'   => (clone $myJobs)->where('status', RepairStatus::COMPLETED)->count(),
                'pool'        => RepairRequest::whereNull('tradesman_id')->where('status', RepairStatus::PENDING)->count(),
            ];
        } else {
            // User ทั่วไป
            $query->where('user_id', $user->id);

            $myRequests = RepairRequest::where('user_id', $user->id);
            $stats = [
                'total'       => (clone $myRequests)->count(),
                'pending'     => (clone $myRequests)->where('status', RepairStatus::PENDING)->count(),
                'in_progress' => (clone $myRequests)->whereIn('status', [RepairStatus::ASSIGNED, RepairStatus::IN_PROGRESS])->count(),
                'completed'   => (clone $myRequests)->where('status', RepairStatus::COMPLETED)->count(),
            ];
        }

        // 2. กรองข้อมูลตามตัวเลือก (Filter)
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        $repairRequests = $query->latest()->paginate(10);

        return view('dashboard', compact('repairRequests', 'tradesmen', 'categories', 'stats'));
    }

    // หน้าฟอร์มสร้างใบแจ้งซ่อมใหม่
    public function create()
    {
        $categories = Category::all();
        return view('repair_requests.create', compact('categories'));
    }

    // บันทึกข้อมูลใบแจ้งซ่อม (สำหรับ User)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'location'    => 'nullable|string|max:255',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:3072',
        ]);

        // จัดการอัปโหลดไฟล์รูปภาพลงดิสก์ public
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('repairs', 'public');
        } else {
            unset($validated['image']);
        }

        $validated['user_id'] = Auth::id();
        $validated['status']  = RepairStatus::PENDING;

        RepairRequest::create($validated);

        return redirect()->route('dashboard')->with('success', 'สร้างใบแจ้งซ่อมเรียบร้อยแล้ว');
    }

    // หน้าแสดงรายละเอียดใบแจ้งซ่อม
    public function show(RepairRequest $repairRequest)
    {
        $repairRequest->load(['user', 'category', 'tradesman']);
        return view('repair_requests.show', compact('repairRequest'));
    }

    // มอบหมายงานช่าง (สำหรับ Admin หรือ ช่างกดรับงานเอง)
    public function assignTradesman(Request $request, RepairRequest $repairRequest)
    {
        $user = Auth::user();

        // กรณีช่างกดรับงานเองจาก Pool
        if ($user->isTradesman()) {
            $repairRequest->update([
                'tradesman_id' => $user->id,
                'status'       => RepairStatus::ASSIGNED,
            ]);

            return back()->with('success', 'คุณได้รับงานนี้เข้าสู่รายการงานของคุณแล้ว');
        }

        // กรณี Admin มอบหมายงานให้ช่าง
        $request->validate([
            'tradesman_id' => 'required|exists:users,id',
        ]);

        $repairRequest->update([
            'tradesman_id' => $request->tradesman_id,
            'status'       => RepairStatus::ASSIGNED,
        ]);

        return back()->with('success', 'มอบหมายช่างผู้ดูแลเรียบร้อยแล้ว');
    }

    // อัปเดตสถานะงานและหมายเหตุ (สำหรับ ช่างซ่อม/Admin)
    public function updateStatus(Request $request, RepairRequest $repairRequest)
    {
        $request->validate([
            'status'      => 'required',
            'admin_notes' => 'nullable|string',
        ]);

        $status = RepairStatus::tryFrom($request->status) ?? $request->status;

        $updateData = ['status' => $status];
        if ($request->has('admin_notes')) {
            $updateData['admin_notes'] = $request->admin_notes;
        }

        $repairRequest->update($updateData);

        return back()->with('success', 'อัปเดตสถานะงานเรียบร้อยแล้ว');
    }
}
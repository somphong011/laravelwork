<div class="py-8 bg-slate-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

        <!-- 1. Resident Portal Hero Header -->
        <div class="relative overflow-hidden bg-gradient-to-r from-blue-700 via-indigo-700 to-purple-800 rounded-3xl p-6 md:p-8 text-white shadow-xl">
            <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <div class="flex items-center gap-2 mb-2">
                        <span class="px-3 py-1 bg-white/20 backdrop-blur-md rounded-full text-xs font-semibold uppercase tracking-wider text-blue-100 flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-blue-300"></span>
                            👤 บัญชีผู้ใช้งาน / Resident Portal
                        </span>
                    </div>
                    <h1 class="text-2xl md:text-3xl font-bold tracking-tight">
                        สวัสดีคุณ {{ auth()->user()->name }} 👋
                    </h1>
                    <p class="text-blue-100 mt-1 text-sm md:text-base">
                        ระบบแจ้งซ่อมและติดตามสถานะงานออนไลน์ แจ้งปัญหาและตรวจสอบความคืบหน้าได้ตลอด 24 ชั่วโมง
                    </p>
                </div>
                <a href="{{ route('repair-requests.create') }}"
                   class="inline-flex items-center gap-2 px-6 py-3.5 bg-white text-indigo-700 hover:bg-blue-50 font-bold rounded-2xl shadow-lg transition duration-200 transform hover:-translate-y-0.5 active:translate-y-0">
                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    สร้างใบแจ้งซ่อมใหม่
                </a>
            </div>
        </div>

        <!-- 2. Flash Notification -->
        @if (session('success'))
            <div x-data="{ show: true }" x-show="show" x-transition
                 class="flex items-center justify-between p-4 bg-emerald-50 border border-emerald-200 rounded-2xl text-emerald-800 shadow-sm">
                <div class="flex items-center gap-3">
                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="font-medium text-sm md:text-base">{{ session('success') }}</span>
                </div>
                <button @click="show = false" class="text-emerald-500 hover:text-emerald-700">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        @endif

        <!-- 3. Bento Stats Grid for Resident -->
        <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Total -->
            <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm">
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">รายการที่คุณแจ้ง</p>
                <div class="flex items-center justify-between mt-2">
                    <h3 class="text-2xl md:text-3xl font-bold text-slate-800">{{ $stats['total'] ?? 0 }}</h3>
                    <div class="p-2.5 bg-blue-50 text-blue-600 rounded-xl">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    </div>
                </div>
            </div>

            <!-- Pending -->
            <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm">
                <p class="text-xs font-semibold text-amber-500 uppercase tracking-wider">รอตรวจสอบ / จ่ายงาน</p>
                <div class="flex items-center justify-between mt-2">
                    <h3 class="text-2xl md:text-3xl font-bold text-slate-800">{{ $stats['pending'] ?? 0 }}</h3>
                    <div class="p-2.5 bg-amber-50 text-amber-500 rounded-xl">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                </div>
            </div>

            <!-- In Progress -->
            <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm">
                <p class="text-xs font-semibold text-indigo-500 uppercase tracking-wider">กำลังดำเนินการซ่อม</p>
                <div class="flex items-center justify-between mt-2">
                    <h3 class="text-2xl md:text-3xl font-bold text-slate-800">{{ $stats['in_progress'] ?? 0 }}</h3>
                    <div class="p-2.5 bg-indigo-50 text-indigo-500 rounded-xl">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    </div>
                </div>
            </div>

            <!-- Completed -->
            <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm">
                <p class="text-xs font-semibold text-emerald-500 uppercase tracking-wider">ซ่อมเสร็จสิ้นแล้ว</p>
                <div class="flex items-center justify-between mt-2">
                    <h3 class="text-2xl md:text-3xl font-bold text-slate-800">{{ $stats['completed'] ?? 0 }}</h3>
                    <div class="p-2.5 bg-emerald-50 text-emerald-500 rounded-xl">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- 4. Filter Bar -->
        <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm">
            <form method="GET" action="{{ route('dashboard') }}" class="grid grid-cols-1 sm:grid-cols-3 gap-3 items-end">
                <div>
                    <label class="block text-xs font-medium text-slate-600 mb-1">ค้นหาหัวข้อของคุณ</label>
                    <div class="relative">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="ค้นหาหัวข้อการแจ้งซ่อม..."
                               class="w-full pl-9 pr-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:bg-white focus:ring-2 focus:ring-indigo-500 transition">
                        <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-medium text-slate-600 mb-1">สถานะงาน</label>
                    <select name="status" class="w-full py-2 px-3 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:bg-white focus:ring-2 focus:ring-indigo-500 transition">
                        <option value="">ทุกสถานะ</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>รอดำเนินการ</option>
                        <option value="assigned" {{ request('status') == 'assigned' ? 'selected' : '' }}>มอบหมายช่างแล้ว</option>
                        <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>กำลังซ่อม</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>เสร็จสิ้น</option>
                    </select>
                </div>

                <div class="flex items-center gap-2">
                    <button type="submit" class="flex-1 py-2 px-4 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-xl text-xs transition shadow-sm">
                        กรองข้อมูล
                    </button>
                    <a href="{{ route('dashboard') }}" class="py-2 px-3 bg-slate-100 hover:bg-slate-200 text-slate-600 font-medium rounded-xl text-xs transition text-center">
                        ล้างค่า
                    </a>
                </div>
            </form>
        </div>

        <!-- 5. User Requests Table -->
        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="p-5 border-b border-slate-100 flex justify-between items-center">
                <div>
                    <h2 class="text-lg font-bold text-slate-800">ประวัติการแจ้งซ่อมของคุณ</h2>
                    <p class="text-xs text-slate-400 mt-0.5">ติดตามขั้นตอนการแก้ไขปัญหาและความคืบหน้าของงานซ่อม</p>
                </div>
                <span class="text-xs px-3 py-1 bg-slate-100 text-slate-600 rounded-full font-medium">
                    ทั้งหมด {{ method_exists($repairRequests, 'total') ? $repairRequests->total() : ($repairRequests?->count() ?? 0) }} รายการ
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/70 text-slate-400 text-xs uppercase tracking-wider font-semibold border-b border-slate-100">
                            <th class="py-3.5 px-6">หัวข้อ / สถานที่</th>
                            <th class="py-3.5 px-6">วันที่แจ้ง</th>
                            <th class="py-3.5 px-6">หมวดหมู่</th>
                            <th class="py-3.5 px-6">สถานะการดำเนินการ</th>
                            <th class="py-3.5 px-6">ช่างผู้ดูแล</th>
                            <th class="py-3.5 px-6 text-right">รายละเอียด</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                        @forelse($repairRequests ?? [] as $request)
                            @php
                                $statusValue = $request->status instanceof \App\Enums\RepairStatus ? $request->status->value : $request->status;
                            @endphp
                            <tr class="hover:bg-slate-50/70 transition">
                                <!-- Title & Location -->
                                <td class="py-4 px-6">
                                    <div class="font-semibold text-slate-800">{{ $request->title }}</div>
                                    <div class="text-xs text-slate-400 flex items-center gap-1 mt-0.5">
                                        <svg class="w-3.5 h-3.5 text-indigo-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                        {{ $request->location ?? 'ไม่ระบุสถานที่' }}
                                    </div>
                                </td>

                                <!-- Date -->
                                <td class="py-4 px-6">
                                    <div class="text-slate-800 font-medium text-xs">{{ $request->created_at?->format('d/m/Y') }}</div>
                                    <div class="text-xs text-slate-400">{{ $request->created_at?->diffForHumans() }}</div>
                                </td>

                                <!-- Category -->
                                <td class="py-4 px-6">
                                    <span class="px-2.5 py-1 bg-slate-100 text-slate-700 rounded-lg text-xs font-medium">
                                        {{ $request->category->name ?? 'ทั่วไป' }}
                                    </span>
                                </td>

                                <!-- Status Badge -->
                                <td class="py-4 px-6">
                                    @if($statusValue === 'pending')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                            รอเจ้าหน้าที่จ่ายงาน
                                        </span>
                                    @elseif($statusValue === 'assigned')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-purple-50 text-purple-700 border border-purple-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-purple-500"></span>
                                            มอบหมายช่างแล้ว
                                        </span>
                                    @elseif($statusValue === 'in_progress')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-blue-500 animate-spin"></span>
                                            ช่างกำลังซ่อมแซม
                                        </span>
                                    @elseif($statusValue === 'completed')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                            <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                            ซ่อมเสร็จสิ้นแล้ว
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-600">
                                            {{ $statusValue }}
                                        </span>
                                    @endif
                                </td>

                                <!-- Tradesman -->
                                <td class="py-4 px-6">
                                    @if($request->tradesman)
                                        <div class="flex items-center gap-1.5 text-xs text-slate-700 font-semibold">
                                            <span class="w-2 h-2 rounded-full bg-indigo-500"></span>
                                            {{ $request->tradesman->name }}
                                        </div>
                                    @else
                                        <span class="text-xs text-slate-400">อยู่ระหว่างจัดสรรช่าง</span>
                                    @endif
                                </td>

                                <!-- Actions -->
                                <td class="py-4 px-6 text-right">
                                    <a href="{{ route('repair-requests.show', $request->id) }}"
                                       class="inline-flex items-center gap-1.5 px-3.5 py-1.5 text-xs font-semibold text-indigo-600 bg-indigo-50 hover:bg-indigo-100 rounded-xl transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        ดูรายละเอียด
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-16 text-center text-slate-400">
                                    <div class="w-16 h-16 mx-auto mb-4 bg-indigo-50 text-indigo-500 rounded-3xl flex items-center justify-center">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    </div>
                                    <p class="text-base font-bold text-slate-700">คุณยังไม่มีประวัติการแจ้งซ่อม</p>
                                    <p class="text-xs text-slate-400 mt-1 mb-4">หากมีสิ่งของหรืออุปกรณ์ชำรุด สามารถกดปุ่มด้านล่างเพื่อแจ้งได้ทันที</p>
                                    <a href="{{ route('repair-requests.create') }}"
                                       class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-2xl shadow-md transition text-xs">
                                        + แจ้งซ่อมรายการแรก
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if(isset($repairRequests) && method_exists($repairRequests, 'hasPages') && $repairRequests->hasPages())
                <div class="p-4 border-t border-slate-100">
                    {{ $repairRequests->withQueryString()->links() }}
                </div>
            @endif
        </div>

    </div>
</div>

<div class="py-8 bg-slate-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

        <!-- 1. Admin Executive Hero Header -->
        <div class="relative overflow-hidden bg-gradient-to-r from-slate-900 via-indigo-950 to-blue-900 rounded-3xl p-6 md:p-8 text-white shadow-xl border border-indigo-900/50">
            <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <div class="flex items-center gap-2 mb-2">
                        <span class="px-3 py-1 bg-amber-400/20 text-amber-300 border border-amber-400/30 rounded-full text-xs font-semibold uppercase tracking-wider flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-amber-400 animate-ping"></span>
                            👑 ผู้ดูแลระบบ / Admin Dispatcher
                        </span>
                    </div>
                    <h1 class="text-2xl md:text-3xl font-bold tracking-tight">
                        ศูนย์ควบคุมและจ่ายงานแจ้งซ่อม
                    </h1>
                    <p class="text-indigo-200 mt-1 text-sm md:text-base">
                        ตรวจสอบคำขอแจ้งซ่อมทั้งหมด มอบหมายช่างผู้เชี่ยวชาญ และติดตามผลการปฏิบัติงาน
                    </p>
                </div>
                <div class="flex flex-wrap items-center gap-3">
                    <a href="{{ route('dashboard', ['status' => 'pending']) }}"
                       class="inline-flex items-center gap-2 px-4 py-2.5 bg-amber-500 hover:bg-amber-600 text-slate-950 font-bold rounded-2xl shadow-lg transition duration-200 text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        รอมอบหมาย ({{ $stats['pending'] ?? 0 }})
                    </a>
                    <a href="{{ route('repair-requests.create') }}"
                       class="inline-flex items-center gap-2 px-4 py-2.5 bg-white/10 hover:bg-white/20 text-white font-semibold rounded-2xl border border-white/20 shadow-sm transition text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        สร้างใบแจ้งซ่อมแทน
                    </a>
                </div>
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

        <!-- 3. Bento Stats Grid for Admin -->
        <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-5 gap-4">
            <!-- Total -->
            <a href="{{ route('dashboard') }}" class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md hover:border-slate-300 transition group">
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">รายการทั้งหมด</p>
                <div class="flex items-center justify-between mt-2">
                    <h3 class="text-2xl md:text-3xl font-bold text-slate-800">{{ $stats['total'] ?? 0 }}</h3>
                    <div class="p-2.5 bg-slate-100 text-slate-600 rounded-xl group-hover:bg-slate-200 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    </div>
                </div>
            </a>

            <!-- Pending (Needs Assignment) -->
            <a href="{{ route('dashboard', ['status' => 'pending']) }}" class="bg-white p-5 rounded-2xl border border-amber-200 bg-amber-50/30 shadow-sm hover:shadow-md hover:border-amber-300 transition group">
                <p class="text-xs font-semibold text-amber-600 uppercase tracking-wider">รอมอบหมายช่าง</p>
                <div class="flex items-center justify-between mt-2">
                    <h3 class="text-2xl md:text-3xl font-bold text-amber-600">{{ $stats['pending'] ?? 0 }}</h3>
                    <div class="p-2.5 bg-amber-100 text-amber-600 rounded-xl group-hover:bg-amber-200 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                </div>
            </a>

            <!-- Assigned -->
            <a href="{{ route('dashboard', ['status' => 'assigned']) }}" class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md hover:border-purple-300 transition group">
                <p class="text-xs font-semibold text-purple-600 uppercase tracking-wider">มอบหมายแล้ว</p>
                <div class="flex items-center justify-between mt-2">
                    <h3 class="text-2xl md:text-3xl font-bold text-purple-700">{{ $stats['assigned'] ?? 0 }}</h3>
                    <div class="p-2.5 bg-purple-50 text-purple-600 rounded-xl group-hover:bg-purple-100 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </div>
                </div>
            </a>

            <!-- In Progress -->
            <a href="{{ route('dashboard', ['status' => 'in_progress']) }}" class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md hover:border-blue-300 transition group">
                <p class="text-xs font-semibold text-blue-600 uppercase tracking-wider">กำลังซ่อม</p>
                <div class="flex items-center justify-between mt-2">
                    <h3 class="text-2xl md:text-3xl font-bold text-blue-600">{{ $stats['in_progress'] ?? 0 }}</h3>
                    <div class="p-2.5 bg-blue-50 text-blue-600 rounded-xl group-hover:bg-blue-100 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    </div>
                </div>
            </a>

            <!-- Completed -->
            <a href="{{ route('dashboard', ['status' => 'completed']) }}" class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md hover:border-emerald-300 transition group">
                <p class="text-xs font-semibold text-emerald-600 uppercase tracking-wider">เสร็จสิ้นแล้ว</p>
                <div class="flex items-center justify-between mt-2">
                    <h3 class="text-2xl md:text-3xl font-bold text-emerald-600">{{ $stats['completed'] ?? 0 }}</h3>
                    <div class="p-2.5 bg-emerald-50 text-emerald-600 rounded-xl group-hover:bg-emerald-100 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    </div>
                </div>
            </a>
        </div>

        <!-- 4. Advanced Admin Filter Bar -->
        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm">
            <form method="GET" action="{{ route('dashboard') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3 items-end">
                <!-- Search -->
                <div>
                    <label class="block text-xs font-medium text-slate-600 mb-1">ค้นหา</label>
                    <div class="relative">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="หัวข้อ, อาการ, สถานที่..."
                               class="w-full pl-9 pr-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                        <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                </div>

                <!-- Category -->
                <div>
                    <label class="block text-xs font-medium text-slate-600 mb-1">หมวดหมู่</label>
                    <select name="category_id" class="w-full py-2 px-3 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                        <option value="">ทุกหมวดหมู่</option>
                        @foreach($categories ?? [] as $category)
                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Status -->
                <div>
                    <label class="block text-xs font-medium text-slate-600 mb-1">สถานะ</label>
                    <select name="status" class="w-full py-2 px-3 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                        <option value="">ทุกสถานะ</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>รอมอบหมายช่าง</option>
                        <option value="assigned" {{ request('status') == 'assigned' ? 'selected' : '' }}>มอบหมายแล้ว</option>
                        <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>กำลังซ่อม</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>เสร็จสิ้น</option>
                    </select>
                </div>

                <!-- Tradesman Filter -->
                <div>
                    <label class="block text-xs font-medium text-slate-600 mb-1">ช่างผู้รับผิดชอบ</label>
                    <select name="tradesman_id" class="w-full py-2 px-3 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                        <option value="">ช่างทุกคน</option>
                        @foreach($tradesmen ?? [] as $tradesman)
                            <option value="{{ $tradesman->id }}" {{ request('tradesman_id') == $tradesman->id ? 'selected' : '' }}>
                                {{ $tradesman->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Buttons -->
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

        <!-- 5. Modern Admin Management Table -->
        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="p-5 border-b border-slate-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2">
                <div>
                    <h2 class="text-lg font-bold text-slate-800">ตารางจัดการและส่งมอบงานช่าง</h2>
                    <p class="text-xs text-slate-400 mt-0.5">คลิกเลือกช่างเพื่อส่งมอบงานทันที หรือคลิกดูรายละเอียดเพื่อตรวจสอบประวัติ</p>
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
                            <th class="py-3.5 px-6">ผู้แจ้ง</th>
                            <th class="py-3.5 px-6">หมวดหมู่</th>
                            <th class="py-3.5 px-6">สถานะงาน</th>
                            <th class="py-3.5 px-6">ช่างผู้รับผิดชอบ / ส่งมอบงาน</th>
                            <th class="py-3.5 px-6 text-right">การจัดการ</th>
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

                                <!-- Requester -->
                                <td class="py-4 px-6">
                                    <div class="font-medium text-slate-800">{{ $request->user->name ?? 'ไม่ระบุ' }}</div>
                                    <div class="text-xs text-slate-400">{{ $request->created_at?->diffForHumans() ?? '-' }}</div>
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
                                            รอมอบหมายช่าง
                                        </span>
                                    @elseif($statusValue === 'assigned')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-purple-50 text-purple-700 border border-purple-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-purple-500"></span>
                                            มอบหมายแล้ว
                                        </span>
                                    @elseif($statusValue === 'in_progress')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-blue-500 animate-spin"></span>
                                            กำลังซ่อม
                                        </span>
                                    @elseif($statusValue === 'completed')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                            <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                            เสร็จสิ้น
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-600">
                                            {{ $statusValue }}
                                        </span>
                                    @endif
                                </td>

                                <!-- Assigned Tradesman / Quick Dispatch -->
                                <td class="py-4 px-6">
                                    <form action="{{ route('repair-requests.assign-tradesman', $request->id) }}" method="POST" class="flex items-center gap-2">
                                        @csrf
                                        <select name="tradesman_id"
                                                class="text-xs py-1.5 px-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:bg-white text-slate-800 transition">
                                            <option value="">-- เลือกช่างผู้ดูแล --</option>
                                            @foreach($tradesmen ?? [] as $tradesman)
                                                <option value="{{ $tradesman->id }}" {{ $request->tradesman_id === $tradesman->id ? 'selected' : '' }}>
                                                    {{ $tradesman->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <button type="submit"
                                                class="px-3 py-1.5 text-xs font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl shadow-sm transition shrink-0">
                                            {{ $request->tradesman_id ? 'เปลี่ยนช่าง' : 'มอบหมาย' }}
                                        </button>
                                    </form>
                                </td>

                                <!-- Actions -->
                                <td class="py-4 px-6 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('repair-requests.show', $request->id) }}"
                                           class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-indigo-600 bg-indigo-50 hover:bg-indigo-100 rounded-xl transition">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            ดูข้อมูล
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-12 text-center text-slate-400">
                                    <svg class="w-12 h-12 mx-auto mb-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                                    <p class="text-base font-medium text-slate-500">ไม่พบรายการแจ้งซ่อม</p>
                                    <p class="text-xs text-slate-400 mt-1">ลองเปลี่ยนตัวกรองค้นหา หรือรอผู้ใช้แจ้งปัญหาใหม่</p>
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

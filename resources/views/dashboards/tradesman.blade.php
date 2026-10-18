<div class="py-8 bg-slate-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

        <!-- 1. Tradesman Workspace Header -->
        <div class="relative overflow-hidden bg-gradient-to-r from-teal-900 via-slate-900 to-indigo-950 rounded-3xl p-6 md:p-8 text-white shadow-xl border border-teal-800/40">
            <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <div class="flex items-center gap-2 mb-2">
                        <span class="px-3 py-1 bg-teal-400/20 text-teal-300 border border-teal-400/30 rounded-full text-xs font-semibold uppercase tracking-wider flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-teal-400"></span>
                            🔧 ช่างผู้เชี่ยวชาญ / Technician Workspace
                        </span>
                    </div>
                    <h1 class="text-2xl md:text-3xl font-bold tracking-tight">
                        สวัสดีช่าง {{ auth()->user()->name }} 🛠️
                    </h1>
                    <p class="text-slate-300 mt-1 text-sm md:text-base">
                        ติดตามรายการงานซ่อมที่คุณรับผิดชอบ อัปเดตสถานะการซ่อม และบันทึกผลงานเสร็จสิ้น
                    </p>
                </div>

                <!-- Tabs: My Jobs vs Available Pool -->
                <div class="flex items-center p-1.5 bg-white/10 backdrop-blur-md rounded-2xl border border-white/10 text-xs">
                    <a href="{{ route('dashboard', ['tab' => 'my_jobs']) }}"
                       class="px-4 py-2 rounded-xl font-semibold transition {{ request('tab', 'my_jobs') === 'my_jobs' ? 'bg-teal-500 text-slate-950 shadow-md' : 'text-slate-200 hover:text-white' }}">
                        งานที่รับมอบหมาย ({{ $stats['my_total'] ?? 0 }})
                    </a>
                    <a href="{{ route('dashboard', ['tab' => 'pool']) }}"
                       class="px-4 py-2 rounded-xl font-semibold transition {{ request('tab') === 'pool' ? 'bg-amber-400 text-slate-950 shadow-md' : 'text-slate-200 hover:text-white' }}">
                        งานรอช่างรับ ({{ $stats['pool'] ?? 0 }})
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

        <!-- 3. Stats for Tradesman -->
        <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Assigned -->
            <a href="{{ route('dashboard', ['tab' => 'my_jobs', 'status' => 'assigned']) }}"
               class="bg-white p-5 rounded-2xl border border-purple-200 bg-purple-50/20 shadow-sm hover:shadow-md transition group">
                <p class="text-xs font-semibold text-purple-600 uppercase tracking-wider">งานรอเริ่มซ่อม</p>
                <div class="flex items-center justify-between mt-2">
                    <h3 class="text-2xl md:text-3xl font-bold text-purple-700">{{ $stats['assigned'] ?? 0 }}</h3>
                    <div class="p-2.5 bg-purple-100 text-purple-600 rounded-xl group-hover:bg-purple-200 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                </div>
            </a>

            <!-- In Progress -->
            <a href="{{ route('dashboard', ['tab' => 'my_jobs', 'status' => 'in_progress']) }}"
               class="bg-white p-5 rounded-2xl border border-blue-200 bg-blue-50/20 shadow-sm hover:shadow-md transition group">
                <p class="text-xs font-semibold text-blue-600 uppercase tracking-wider">กำลังลงมือซ่อม</p>
                <div class="flex items-center justify-between mt-2">
                    <h3 class="text-2xl md:text-3xl font-bold text-blue-600">{{ $stats['in_progress'] ?? 0 }}</h3>
                    <div class="p-2.5 bg-blue-100 text-blue-600 rounded-xl group-hover:bg-blue-200 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    </div>
                </div>
            </a>

            <!-- Completed -->
            <a href="{{ route('dashboard', ['tab' => 'my_jobs', 'status' => 'completed']) }}"
               class="bg-white p-5 rounded-2xl border border-emerald-200 bg-emerald-50/20 shadow-sm hover:shadow-md transition group">
                <p class="text-xs font-semibold text-emerald-600 uppercase tracking-wider">ซ่อมเสร็จแล้ว</p>
                <div class="flex items-center justify-between mt-2">
                    <h3 class="text-2xl md:text-3xl font-bold text-emerald-600">{{ $stats['completed'] ?? 0 }}</h3>
                    <div class="p-2.5 bg-emerald-100 text-emerald-600 rounded-xl group-hover:bg-emerald-200 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    </div>
                </div>
            </a>

            <!-- Pool -->
            <a href="{{ route('dashboard', ['tab' => 'pool']) }}"
               class="bg-white p-5 rounded-2xl border border-amber-200 bg-amber-50/20 shadow-sm hover:shadow-md transition group">
                <p class="text-xs font-semibold text-amber-600 uppercase tracking-wider">งานรอช่างรับ</p>
                <div class="flex items-center justify-between mt-2">
                    <h3 class="text-2xl md:text-3xl font-bold text-amber-600">{{ $stats['pool'] ?? 0 }}</h3>
                    <div class="p-2.5 bg-amber-100 text-amber-600 rounded-xl group-hover:bg-amber-200 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                    </div>
                </div>
            </a>
        </div>

        <!-- 4. Filter -->
        <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm flex flex-col sm:flex-row items-center justify-between gap-3">
            <form method="GET" action="{{ route('dashboard') }}" class="flex flex-wrap items-center gap-2 w-full sm:w-auto">
                <input type="hidden" name="tab" value="{{ request('tab', 'my_jobs') }}">
                <div class="relative flex-1 sm:w-64">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="ค้นหางาน, สถานที่..."
                           class="w-full pl-9 pr-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:bg-white focus:ring-2 focus:ring-teal-500 transition">
                    <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                <select name="category_id" class="py-2 px-3 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:bg-white focus:ring-2 focus:ring-teal-500 transition">
                    <option value="">ทุกหมวดหมู่</option>
                    @foreach($categories ?? [] as $category)
                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
                <button type="submit" class="px-4 py-2 bg-slate-800 hover:bg-slate-900 text-white font-medium rounded-xl text-xs transition">
                    ค้นหา
                </button>
            </form>
            <span class="text-xs text-slate-400">
                แสดงผล: {{ request('tab') === 'pool' ? 'รายการงานส่วนกลาง' : 'รายการงานของฉัน' }}
            </span>
        </div>

        <!-- 5. Work Order Cards Grid (Technician Focus) -->
        <div class="space-y-4">
            @forelse($repairRequests ?? [] as $request)
                @php
                    $statusValue = $request->status instanceof \App\Enums\RepairStatus ? $request->status->value : $request->status;
                @endphp
                <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6 hover:shadow-md transition flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6"
                     x-data="{ showFinishModal: false }">
                    
                    <!-- Left: Details -->
                    <div class="flex items-start gap-4 flex-1">
                        <!-- Category Badge Icon -->
                        <div class="w-12 h-12 rounded-2xl bg-teal-50 text-teal-700 flex items-center justify-center shrink-0 border border-teal-100 shadow-inner">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>

                        <div class="space-y-1.5">
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="px-2.5 py-0.5 rounded-lg text-xs font-semibold bg-slate-100 text-slate-700">
                                    {{ $request->category->name ?? 'ทั่วไป' }}
                                </span>

                                <!-- Status Badge -->
                                @if($statusValue === 'pending')
                                    <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                                        รอช่างรับเรื่อง
                                    </span>
                                @elseif($statusValue === 'assigned')
                                    <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-purple-50 text-purple-700 border border-purple-200">
                                        มอบหมายแล้ว (รอเริ่มซ่อม)
                                    </span>
                                @elseif($statusValue === 'in_progress')
                                    <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-200 animate-pulse">
                                        กำลังซ่อมแซม
                                    </span>
                                @elseif($statusValue === 'completed')
                                    <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        ซ่อมเสร็จสิ้นแล้ว
                                    </span>
                                @endif

                                <span class="text-xs text-slate-400">#REQ-{{ $request->id }}</span>
                            </div>

                            <h3 class="text-base font-bold text-slate-800">
                                {{ $request->title }}
                            </h3>

                            <div class="flex flex-wrap items-center gap-4 text-xs text-slate-500">
                                <span class="flex items-center gap-1 font-semibold text-slate-700">
                                    <svg class="w-4 h-4 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    {{ $request->location ?? 'ไม่ระบุสถานที่' }}
                                </span>
                                <span>ผู้แจ้ง: {{ $request->user->name ?? 'ไม่ระบุ' }}</span>
                                <span>แจ้งเมื่อ: {{ $request->created_at?->diffForHumans() }}</span>
                            </div>

                            <p class="text-xs text-slate-600 line-clamp-2 pt-1 bg-slate-50 p-2.5 rounded-xl border border-slate-100">
                                {{ $request->description }}
                            </p>
                        </div>
                    </div>

                    <!-- Right: Quick Actions -->
                    <div class="flex flex-wrap items-center gap-2 w-full lg:w-auto justify-end border-t lg:border-t-0 pt-3 lg:pt-0 border-slate-100 shrink-0">
                        <!-- View detail -->
                        <a href="{{ route('repair-requests.show', $request->id) }}"
                           class="px-4 py-2 text-xs font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl transition">
                            ดูรายละเอียด
                        </a>

                        <!-- Action: Claim Job (if in pool) -->
                        @if(request('tab') === 'pool' && !$request->tradesman_id)
                            <form action="{{ route('repair-requests.assign-tradesman', $request->id) }}" method="POST">
                                @csrf
                                <button type="submit"
                                        class="px-4 py-2 text-xs font-semibold text-white bg-teal-600 hover:bg-teal-700 rounded-xl shadow-sm transition flex items-center gap-1.5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    รับงานนี้
                                </button>
                            </form>
                        @endif

                        <!-- Action: Start Job (assigned -> in_progress) -->
                        @if($request->tradesman_id === auth()->id() && $statusValue === 'assigned')
                            <form action="{{ route('repair-requests.update-status', $request->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="status" value="in_progress">
                                <button type="submit"
                                        class="px-5 py-2 text-xs font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-xl shadow-md transition flex items-center gap-1.5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    เริ่มลงมือซ่อม
                                </button>
                            </form>
                        @endif

                        <!-- Action: Finish Job (in_progress -> completed) -->
                        @if($request->tradesman_id === auth()->id() && $statusValue === 'in_progress')
                            <button type="button"
                                    @click="showFinishModal = true"
                                    class="px-5 py-2 text-xs font-semibold text-white bg-emerald-600 hover:bg-emerald-700 rounded-xl shadow-md transition flex items-center gap-1.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                บันทึกงานเสร็จสิ้น
                            </button>

                            <!-- Finish Job Modal -->
                            <div x-show="showFinishModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
                                <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                                    <div class="fixed inset-0 transition-opacity bg-slate-900/60 backdrop-blur-sm" @click="showFinishModal = false"></div>

                                    <div class="inline-block w-full max-w-lg p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-2xl rounded-3xl">
                                        <h3 class="text-lg font-bold text-slate-800">ยืนยันเสร็จสิ้นงานซ่อม</h3>
                                        <p class="text-xs text-slate-500 mt-1">ใบแจ้งซ่อม #{{ $request->id }} : {{ $request->title }}</p>

                                        <form action="{{ route('repair-requests.update-status', $request->id) }}" method="POST" class="mt-4 space-y-4">
                                            @csrf
                                            <input type="hidden" name="status" value="completed">

                                            <div>
                                                <label class="block text-xs font-semibold text-slate-700 mb-1">บันทึกผลการปฏิบัติงานของช่าง (หมายเหตุ)</label>
                                                <textarea name="admin_notes" rows="3" placeholder="ระบุการแก้ไข เช่น เปลี่ยนอะไหล่ใหม่แล้ว, ทดสอบเปิดเครื่องใช้งานได้ปกติ..."
                                                          class="w-full p-3 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:ring-2 focus:ring-emerald-500 text-slate-800"></textarea>
                                            </div>

                                            <div class="flex items-center justify-end gap-2 pt-2">
                                                <button type="button" @click="showFinishModal = false"
                                                        class="px-4 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-100 rounded-xl transition">
                                                    ยกเลิก
                                                </button>
                                                <button type="submit"
                                                        class="px-5 py-2 text-xs font-semibold text-white bg-emerald-600 hover:bg-emerald-700 rounded-xl shadow-md transition">
                                                    ยืนยันปิดงานซ่อม
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-3xl border border-slate-100 p-12 text-center text-slate-400">
                    <svg class="w-12 h-12 mx-auto mb-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <p class="text-base font-semibold text-slate-700">ไม่มีรายการงานซ่อมในหมวดหมู่นี้</p>
                    <p class="text-xs text-slate-400 mt-1">เยี่ยมมาก! ไม่มีงานค้างในกล่องข้อความของคุณ</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if(isset($repairRequests) && method_exists($repairRequests, 'hasPages') && $repairRequests->hasPages())
            <div class="p-4 bg-white rounded-2xl border border-slate-100">
                {{ $repairRequests->withQueryString()->links() }}
            </div>
        @endif

    </div>
</div>

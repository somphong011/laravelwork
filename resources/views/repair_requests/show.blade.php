<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between max-w-4xl mx-auto">
            <h2 class="font-bold text-xl text-slate-800 leading-tight">
                {{ __('รายละเอียดใบแจ้งซ่อม') }} #{{ $repairRequest->id }}
            </h2>
            <a href="{{ route('dashboard') }}" class="text-sm font-medium text-slate-500 hover:text-slate-800 transition">
                &larr; กลับหน้าหลัก
            </a>
        </div>
    </x-slot>

    <div class="py-8 bg-slate-50/50 min-h-[calc(100vh-80px)]">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden p-6 md:p-8">
                <!-- หัวข้อ & สถานะ -->
                <div class="flex flex-col md:flex-row md:items-center justify-between border-b border-slate-100 pb-6 gap-4">
                    <div>
                        <span class="px-3 py-1 bg-indigo-50 text-indigo-700 text-xs font-semibold rounded-lg">
                            {{ $repairRequest->category->name ?? 'หมวดทั่วไป' }}
                        </span>
                        <h1 class="text-2xl font-bold text-slate-800 mt-2">{{ $repairRequest->title }}</h1>
                        <p class="text-sm text-slate-400 mt-1">📍 สถานที่: {{ $repairRequest->location ?? 'ไม่ระบุ' }}</p>
                    </div>

                    @php
                        $statusValue = $repairRequest->status->value ?? $repairRequest->status;
                        $badgeClasses = match($statusValue) {
                            'pending'     => 'bg-amber-50 text-amber-700 border-amber-200',
                            'assigned'    => 'bg-purple-50 text-purple-700 border-purple-200',
                            'in_progress' => 'bg-blue-50 text-blue-700 border-blue-200',
                            'completed'   => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                            default       => 'bg-slate-100 text-slate-600 border-slate-200',
                        };
                    @endphp
                    <div>
                        <span class="px-4 py-2 text-sm font-bold rounded-xl border inline-block {{ $badgeClasses }}">
                            สถานะ: {{ strtoupper($statusValue) }}
                        </span>
                    </div>
                </div>

                <!-- ผู้แจ้งซ่อม & ช่างรับผิดชอบ -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 py-6 border-b border-slate-100 text-sm">
                    <div>
                        <p class="text-xs text-slate-400 uppercase font-semibold">ผู้แจ้งเรื่อง</p>
                        <p class="font-bold text-slate-800 mt-1">{{ $repairRequest->user->name ?? '-' }}</p>
                        <p class="text-xs text-slate-500">{{ $repairRequest->created_at->format('d/m/Y H:i น.') }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 uppercase font-semibold">ช่างผู้ดูแล</p>
                        <p class="font-bold text-slate-800 mt-1">{{ $repairRequest->tradesman->name ?? 'ยังไม่มอบหมายช่าง' }}</p>
                    </div>
                </div>

                <!-- รายละเอียดอาการ -->
                <div class="py-6 border-b border-slate-100">
                    <h3 class="text-sm font-semibold text-slate-700 mb-2">รายละเอียดความชำรุด</h3>
                    <p class="text-slate-600 whitespace-pre-line leading-relaxed bg-slate-50 p-4 rounded-xl text-sm border border-slate-100">
                        {{ $repairRequest->description }}
                    </p>
                </div>

                <!-- รูปภาพประกอบ -->
                @php $imageSrc = $repairRequest->image ?? $repairRequest->image_path; @endphp
                @if($imageSrc)
                    <div class="py-6 border-b border-slate-100">
                        <h3 class="text-sm font-semibold text-slate-700 mb-3">รูปภาพประกอบ</h3>
                        <div class="max-w-md overflow-hidden rounded-2xl border border-slate-200 shadow-sm">
                            <img src="{{ asset('storage/' . $imageSrc) }}" alt="รูปภาพการแจ้งซ่อม" class="w-full h-auto object-cover">
                        </div>
                    </div>
                @endif

                <!-- หมายเหตุช่าง/ผู้ดูแล -->
                @if($repairRequest->admin_notes)
                    <div class="pt-6">
                        <h3 class="text-sm font-semibold text-slate-700 mb-2">หมายเหตุจากช่าง/ผู้ดูแล</h3>
                        <div class="p-4 bg-amber-50/60 border border-amber-200/60 rounded-xl text-slate-700 text-sm">
                            {{ $repairRequest->admin_notes }}
                        </div>
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
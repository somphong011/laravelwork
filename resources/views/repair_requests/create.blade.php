<x-app-layout>
    <div class="py-8 bg-slate-50 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <!-- Breadcrumb & Top Bar -->
            <div class="flex items-center justify-between">
                <nav class="flex items-center space-x-2 text-sm text-slate-500">
                    <a href="{{ route('dashboard') }}" class="hover:text-indigo-600 transition flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        หน้าแดชบอร์ด
                    </a>
                    <span>/</span>
                    <span class="font-medium text-slate-800">แจ้งซ่อมใหม่</span>
                </nav>

                <a href="{{ route('dashboard') }}"
                   class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-600 hover:text-slate-900 bg-white hover:bg-slate-100 px-3.5 py-2 rounded-xl border border-slate-200 shadow-sm transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    ย้อนกลับ
                </a>
            </div>

            <!-- Hero Header Card -->
            <div class="relative overflow-hidden bg-gradient-to-r from-blue-700 via-indigo-700 to-purple-800 rounded-3xl p-6 md:p-8 text-white shadow-xl">
                <div class="relative z-10 flex flex-col md:flex-row justify-between md:items-center gap-4">
                    <div>
                        <div class="inline-flex items-center gap-2 px-3 py-1 bg-white/20 backdrop-blur-md rounded-full text-xs font-medium uppercase tracking-wider text-blue-100 mb-2">
                            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                            ระบบแจ้งซ่อมออนไลน์
                        </div>
                        <h1 class="text-2xl md:text-3xl font-bold tracking-tight">
                            สร้างใบแจ้งซ่อมใหม่
                        </h1>
                        <p class="text-blue-100 mt-1 text-sm md:text-base">
                            กรอกรายละเอียดความชำรุดเพื่อให้ทีมช่างเข้าตรวจสอบและแก้ไขปัญหาได้อย่างรวดเร็ว
                        </p>
                    </div>

                    <!-- Flow Badge -->
                    <div class="hidden sm:flex items-center gap-2 bg-white/10 backdrop-blur-md px-4 py-2.5 rounded-2xl border border-white/10 text-xs">
                        <div class="w-6 h-6 rounded-full bg-white text-indigo-700 font-bold flex items-center justify-center">1</div>
                        <span class="font-medium text-white">แจ้งข้อมูล</span>
                        <svg class="w-4 h-4 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        <div class="w-6 h-6 rounded-full bg-white/20 text-white font-medium flex items-center justify-center">2</div>
                        <span class="text-white/70">มอบหมายช่าง</span>
                        <svg class="w-4 h-4 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        <div class="w-6 h-6 rounded-full bg-white/20 text-white font-medium flex items-center justify-center">3</div>
                        <span class="text-white/70">เสร็จสิ้น</span>
                    </div>
                </div>
            </div>

            <!-- Main Form Card -->
            <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
                <form action="{{ route('repair-requests.store') }}"
                      method="POST"
                      enctype="multipart/form-data"
                      x-data="{
                          photoPreview: null,
                          photoName: null,
                          isDropping: false,
                          handleFile(file) {
                              if (!file) return;
                              this.photoName = file.name;
                              const reader = new FileReader();
                              reader.onload = (e) => { this.photoPreview = e.target.result; };
                              reader.readAsDataURL(file);
                          },
                          clearPhoto() {
                              this.photoPreview = null;
                              this.photoName = null;
                              $refs.photoInput.value = '';
                          }
                      }"
                      class="p-6 md:p-10 space-y-8">
                    @csrf

                    <!-- Section 1: หมวดหมู่ & สถานที่ -->
                    <div>
                        <div class="flex items-center gap-2 pb-3 mb-6 border-b border-slate-100">
                            <span class="w-7 h-7 rounded-xl bg-indigo-50 text-indigo-600 font-bold text-xs flex items-center justify-center">1</span>
                            <h2 class="text-base font-bold text-slate-800">ข้อมูลหมวดหมู่และสถานที่</h2>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- หมวดหมู่งานซ่อม -->
                            <div>
                                <label for="category_id" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">
                                    หมวดหมู่งานซ่อม <span class="text-rose-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                                    </div>
                                    <select id="category_id"
                                            name="category_id"
                                            required
                                            class="w-full pl-11 pr-10 py-3 bg-slate-50/70 hover:bg-slate-50 focus:bg-white border border-slate-200 rounded-2xl text-sm text-slate-800 focus:outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 transition shadow-sm">
                                        <option value="">-- เลือกหมวดหมู่ความชำรุด --</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <x-input-error :messages="$errors->get('category_id')" class="mt-1.5" />
                                <p class="text-[11px] text-slate-400 mt-1.5">เลือกหมวดหมู่ที่ตรงกับปัญหาเพื่อให้ส่งต่องานถูกช่างผู้เชี่ยวชาญ</p>
                            </div>

                            <!-- สถานที่เกิดเหตุ -->
                            <div>
                                <label for="location" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">
                                    สถานที่ / อาคาร / ชั้น / ห้อง
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    </div>
                                    <input type="text"
                                           id="location"
                                           name="location"
                                           value="{{ old('location') }}"
                                           placeholder="เช่น อาคาร A ชั้น 3 ห้อง 302 หรือ ระเบียงทางเดิน"
                                           class="w-full pl-11 pr-4 py-3 bg-slate-50/70 hover:bg-slate-50 focus:bg-white border border-slate-200 rounded-2xl text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 transition shadow-sm" />
                                </div>
                                <x-input-error :messages="$errors->get('location')" class="mt-1.5" />
                                <p class="text-[11px] text-slate-400 mt-1.5">ระบุตำแหน่งที่ชัดเจนเพื่อให้ช่างเข้าถึงหน้างานได้สะดวก</p>
                            </div>
                        </div>
                    </div>

                    <!-- Section 2: รายละเอียดปัญหา -->
                    <div>
                        <div class="flex items-center gap-2 pb-3 mb-6 border-b border-slate-100">
                            <span class="w-7 h-7 rounded-xl bg-indigo-50 text-indigo-600 font-bold text-xs flex items-center justify-center">2</span>
                            <h2 class="text-base font-bold text-slate-800">รายละเอียดอาการชำรุด</h2>
                        </div>

                        <div class="space-y-6">
                            <!-- หัวข้อเรื่อง -->
                            <div>
                                <label for="title" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">
                                    หัวข้อเรื่อง / อาการเสียสั้นๆ <span class="text-rose-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/></svg>
                                    </div>
                                    <input type="text"
                                           id="title"
                                           name="title"
                                           value="{{ old('title') }}"
                                           required
                                           placeholder="เช่น เครื่องปรับอากาศมีน้ำหยด, หลอดไฟทางเดินดับ, ก๊อกน้ำปิดไม่สนิท"
                                           class="w-full pl-11 pr-4 py-3 bg-slate-50/70 hover:bg-slate-50 focus:bg-white border border-slate-200 rounded-2xl text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 transition shadow-sm" />
                                </div>
                                <x-input-error :messages="$errors->get('title')" class="mt-1.5" />
                            </div>

                            <!-- รายละเอียดเพิ่มเติม -->
                            <div>
                                <label for="description" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">
                                    คำอธิบายอาการชำรุดโดยละเอียด <span class="text-rose-500">*</span>
                                </label>
                                <textarea id="description"
                                          name="description"
                                          rows="4"
                                          required
                                          placeholder="อธิบายอาการอย่างละเอียด เช่น น้ำหยดจากใต้เครื่องด้านขวา มีเสียงดังแปลกๆ หรือเริ่มมีปัญหาตั้งแต่เมื่อไหร่ เพื่อให้ช่างเตรียมอุปกรณ์อะไหล่มาได้อย่างถูกต้อง..."
                                          class="w-full p-4 bg-slate-50/70 hover:bg-slate-50 focus:bg-white border border-slate-200 rounded-2xl text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 transition shadow-sm leading-relaxed">{{ old('description') }}</textarea>
                                <x-input-error :messages="$errors->get('description')" class="mt-1.5" />
                            </div>
                        </div>
                    </div>

                    <!-- Section 3: รูปภาพประกอบ -->
                    <div>
                        <div class="flex items-center gap-2 pb-3 mb-6 border-b border-slate-100">
                            <span class="w-7 h-7 rounded-xl bg-indigo-50 text-indigo-600 font-bold text-xs flex items-center justify-center">3</span>
                            <div class="flex items-center gap-2">
                                <h2 class="text-base font-bold text-slate-800">รูปภาพประกอบ</h2>
                                <span class="text-xs text-slate-400">(ถ้ามี)</span>
                            </div>
                        </div>

                        <!-- File Input Zone -->
                        <div>
                            <!-- Hidden Native File Input -->
                            <input id="image"
                                   name="image"
                                   type="file"
                                   accept="image/png,image/jpeg,image/jpg,image/webp"
                                   x-ref="photoInput"
                                   @change="handleFile($event.target.files[0])"
                                   class="hidden" />

                            <!-- Drag & Drop / Click Box (when no preview) -->
                            <div x-show="!photoPreview"
                                 @dragover.prevent="isDropping = true"
                                 @dragleave.prevent="isDropping = false"
                                 @drop.prevent="isDropping = false; if ($event.dataTransfer.files.length) { $refs.photoInput.files = $event.dataTransfer.files; handleFile($event.dataTransfer.files[0]); }"
                                 @click="$refs.photoInput.click()"
                                 :class="{ 'border-indigo-500 bg-indigo-50/40 ring-4 ring-indigo-500/10': isDropping, 'border-slate-200 hover:border-indigo-400 hover:bg-indigo-50/20': !isDropping }"
                                 class="relative cursor-pointer border-2 border-dashed rounded-3xl p-8 text-center transition duration-200 bg-slate-50/40">
                                
                                <div class="w-16 h-16 mx-auto mb-3 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center shadow-inner">
                                    <svg style="width: 32px; height: 32px; max-width: 32px;" class="w-8 h-8 shrink-0 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>

                                <div class="text-sm font-semibold text-slate-700">
                                    ลากไฟล์รูปภาพมาวางที่นี่ หรือ <span class="text-indigo-600 underline underline-offset-2">คลิกเพื่อเลือกไฟล์</span>
                                </div>
                                <p class="text-xs text-slate-400 mt-1.5">
                                    รองรับไฟล์ PNG, JPG, JPEG หรือ WEBP (ขนาดไม่เกิน 3MB)
                                </p>
                            </div>

                            <!-- Live Photo Preview (when preview exists) -->
                            <div x-show="photoPreview" x-cloak class="p-4 bg-slate-50 rounded-3xl border border-slate-200/80">
                                <div class="flex flex-col sm:flex-row items-center gap-5">
                                    <div class="relative w-full sm:w-48 h-36 rounded-2xl overflow-hidden bg-slate-200 border border-slate-300 shadow-sm shrink-0">
                                        <img :src="photoPreview" alt="ตัวอย่างรูปภาพ" class="w-full h-full object-cover">
                                    </div>
                                    <div class="flex-1 w-full space-y-2">
                                        <div class="flex items-center gap-2">
                                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                                            <p class="text-xs font-semibold text-emerald-700 uppercase tracking-wider">เลือกรูปภาพเรียบร้อยแล้ว</p>
                                        </div>
                                        <p class="text-sm font-medium text-slate-800 truncate" x-text="photoName || 'รูปภาพที่เลือก'"></p>
                                        <p class="text-xs text-slate-400">รูปภาพนี้จะถูกแนบไปกับใบแจ้งซ่อมเพื่อให้ช่างประเมินหน้างานได้</p>
                                        
                                        <div class="pt-2 flex items-center gap-3">
                                            <button type="button"
                                                    @click="$refs.photoInput.click()"
                                                    class="px-3.5 py-1.5 text-xs font-semibold bg-white hover:bg-slate-100 text-slate-700 rounded-xl border border-slate-200 transition shadow-sm">
                                                เปลี่ยนรูปภาพ
                                            </button>
                                            <button type="button"
                                                    @click="clearPhoto()"
                                                    class="px-3.5 py-1.5 text-xs font-semibold bg-rose-50 hover:bg-rose-100 text-rose-600 rounded-xl border border-rose-100 transition">
                                                ลบรูปภาพ
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <x-input-error :messages="$errors->get('image')" class="mt-2" />
                        </div>
                    </div>

                    <!-- Tip Notice -->
                    <div class="p-4 bg-amber-50/80 border border-amber-200/60 rounded-2xl flex items-start gap-3 text-amber-900 text-xs">
                        <svg class="w-5 h-5 text-amber-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div class="leading-relaxed">
                            <strong class="font-semibold text-amber-800">กรณีเกิดเหตุฉุกเฉินเร่งด่วน:</strong> หากมีเหตุกรณีฉุกเฉิน เช่น ไฟฟ้าลัดวงจร ท่อประปาหลักแตก หรือกลิ่นแก๊สรั่ว กรุณาติดต่อฝ่ายนิติบุคคลหรือศูนย์ประสานงานช่างทันทีโดยไม่ต้องรอระบบแจ้งซ่อม
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="pt-6 border-t border-slate-100 flex flex-col-reverse sm:flex-row items-center justify-end gap-3">
                        <a href="{{ route('dashboard') }}"
                           class="w-full sm:w-auto px-6 py-3 text-center text-sm font-semibold text-slate-600 hover:text-slate-800 hover:bg-slate-100 rounded-2xl border border-slate-200 transition">
                            ยกเลิก
                        </a>
                        <button type="submit"
                                class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-3.5 text-sm font-semibold text-white bg-gradient-to-r from-blue-600 via-indigo-600 to-indigo-700 hover:from-blue-700 hover:via-indigo-700 hover:to-indigo-800 rounded-2xl shadow-lg shadow-indigo-500/25 hover:shadow-indigo-500/35 transition-all transform hover:-translate-y-0.5 active:translate-y-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                            </svg>
                            ส่งใบแจ้งซ่อม
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
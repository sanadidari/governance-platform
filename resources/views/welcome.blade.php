    <!-- SFTP VERIFICATION BAR -->
    <div style="background-color: #059669; color: white; text-align: center; padding: 10px; font-weight: bold; border-bottom: 3px solid #047857;">
        SFTP SYNC WORKING - LAST UPDATE: {{ date('H:i:s') }}
    </div>
    
    <!--  Hero Section -->
    <div class="relative bg-brand-dark overflow-hidden">
        <div class="max-w-7xl mx-auto">
            <div class="relative z-10 pb-8 bg-brand-dark sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32 px-4 sm:px-6 lg:px-8 pt-10">
                <main class="mt-10 mx-auto max-w-7xl sm:mt-12 md:mt-16 lg:mt-20 xl:mt-28">
                    <div class="sm:text-center lg:text-right">
                        <h1 class="text-4xl tracking-tight font-extrabold text-white sm:text-5xl md:text-6xl">
                            <span class="block xl:inline">التحول الرقمي لمهنة</span>
                            <span class="block text-brand-gold mt-2">المفوضين القضائيين</span>
                        </h1>
                        <p class="mt-3 text-base text-gray-300 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0">
                            منصة موحدة ومبتكرة لتدبير الإجراءات القضائية، تتبع التبليغ والتنفيذ، وضمان الشفافية والنجاعة في العمل القضائي بالمملكة.
                        </p>

                        <div class="mt-5 sm:mt-8 sm:flex sm:justify-center lg:justify-start gap-4">
                            <div class="rounded-md shadow">
                                <a href="#portals" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-brand-primary bg-brand-gold hover:bg-yellow-500 md:py-4 md:text-lg md:px-10 transition transform hover:scale-105">
                                    ابدأ الآن
                                </a>
                            </div>
                            <div class="mt-3 sm:mt-0 sm:ml-3">
                                <a href="{{ url('documentation/PROJECT_OVERVIEW.md') }}" target="_blank" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-brand-gold bg-brand-primary hover:bg-gray-700 md:py-4 md:text-lg md:px-10 border-brand-gold transition">
                                    تعرف على المشروع
                                </a>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
        <!-- Decorative Image/Gradient -->
        <div class="lg:absolute lg:inset-y-0 lg:left-0 lg:w-1/2 bg-gradient-to-r from-brand-dark to-brand-primary opacity-50">
            <img class="h-56 w-full object-cover sm:h-72 md:h-96 lg:w-full lg:h-full opacity-30 mix-blend-overlay" src="https://images.unsplash.com/photo-1589829085413-56de8ae18c73?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1950&q=80" alt="Justice Gavel">
        </div>
    </div>

    <!-- Portals Selection Section -->
    <div id="portals" class="bg-gray-50 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-base text-brand-gold font-semibold tracking-wide uppercase">فضاءات العمل</h2>
                <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-brand-dark sm:text-4xl">اختر بوابة الدخول الخاصة بك</p>
                <p class="mt-4 max-w-2xl text-xl text-gray-500 mx-auto">
                    تم تصميم منصة مخصصة لكل متدخل في المنظومة لضمان سهولة الاستخدام وتخصيص الصلاحيات.
                </p>
            </div>

            <div class="mt-16 grid grid-cols-1 gap-8 md:grid-cols-3">
                
                <!-- National Admin Card -->
                <div class="flex flex-col bg-white rounded-2xl shadow-xl overflow-hidden hover:shadow-2xl transition duration-300 transform hover:-translate-y-2 border-t-4 border-blue-800">
                    <div class="px-6 py-8 flex-1 flex flex-col items-center text-center">
                        <div class="bg-blue-100 p-4 rounded-full mb-6">
                            <svg class="h-10 w-10 text-blue-800" fill="none" class="w-6 h-6" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">الإدارة المركزية</h3>
                        <p class="text-sm text-blue-600 font-semibold mb-4">المسؤول الوطني (National Admin)</p>
                        <p class="text-gray-500 text-sm mb-6 flex-1">
                            تدبير الخريطة القضائية، الإشراف على السجل الوطني للمفوضين، ومراقبة مؤشرات الأداء الوطنية.
                        </p>
                        <div class="w-full space-y-3">
                            <a href="https://sanadidari.com/testftp/gov/portal/login" class="block w-full bg-blue-800 text-white font-bold py-3 px-4 rounded-lg hover:bg-blue-900 transition">
                                دخول الإدارة
                            </a>
                            <a href="{{ asset('documentation/Guide_Admin_National.pdf') }}" target="_blank" class="block w-full bg-blue-50 text-blue-700 font-semibold py-2 px-4 rounded-lg hover:bg-blue-100 transition text-sm flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                تحميل الدليل
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Regional Admin Card -->
                <div class="flex flex-col bg-white rounded-2xl shadow-xl overflow-hidden hover:shadow-2xl transition duration-300 transform hover:-translate-y-2 border-t-4 border-green-600">
                    <div class="px-6 py-8 flex-1 flex flex-col items-center text-center">
                        <div class="bg-green-100 p-4 rounded-full mb-6">
                            <svg class="h-10 w-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">الإدارة الجهوية</h3>
                        <p class="text-sm text-green-600 font-semibold mb-4">المسؤول الجهوي (Regional Admin)</p>
                        <p class="text-gray-500 text-sm mb-6 flex-1">
                            تتبع سير الإجراءات بالدائرة الاستئنافية، تدبير العلاقة مع المفوضين، والتقارير الإحصائية المحلية.
                        </p>
                        <div class="w-full space-y-3">
                            <a href="https://sanadidari.com/testftp/gov/portal/login" class="block w-full bg-green-600 text-white font-bold py-3 px-4 rounded-lg hover:bg-green-700 transition">
                                دخول البوابة الجهوية
                            </a>
                            <a href="{{ asset('documentation/Guide_Admin_Regional.pdf') }}" target="_blank" class="block w-full bg-green-50 text-green-700 font-semibold py-2 px-4 rounded-lg hover:bg-green-100 transition text-sm flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                تحميل الدليل
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Huissier Card -->
                <div class="flex flex-col bg-white rounded-2xl shadow-xl overflow-hidden hover:shadow-2xl transition duration-300 transform hover:-translate-y-2 border-t-4 border-brand-gold">
                    <div class="px-6 py-8 flex-1 flex flex-col items-center text-center">
                        <div class="bg-yellow-100 p-4 rounded-full mb-6">
                            <svg class="h-10 w-10 text-brand-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"></path></svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">فضاء المفوض</h3>
                        <p class="text-sm text-yellow-600 font-semibold mb-4">المفوض القضائي (Huissier)</p>
                        <p class="text-gray-500 text-sm mb-6 flex-1">
                            رقمنة الملفات (تبليغ، تنفيذ)، تحيين الحالات، والولوج إلى التطبيق المحمول QR-PRUF.
                        </p>
                        <div class="w-full space-y-3">
                            <a href="https://sanadidari.com/testftp/gov/portal/login" class="block w-full bg-brand-gold text-white font-bold py-3 px-4 rounded-lg hover:bg-yellow-600 transition">
                                دخول مكتبي الرقمي
                            </a>
                            <a href="{{ asset('documentation/Guide_Huissier_Justice.pdf') }}" target="_blank" class="block w-full bg-yellow-50 text-yellow-700 font-semibold py-2 px-4 rounded-lg hover:bg-yellow-100 transition text-sm flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                تحميل الدليل
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-layouts.public>

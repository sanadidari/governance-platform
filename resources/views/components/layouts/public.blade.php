<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'المنصة الوطنية للمفوضين القضائيين - المملكة المغربية' }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700;900&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS (CDN for immediate rendering without build step) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Cairo', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            gold: '#d4af37',
                            dark: '#1e293b',
                            primary: '#0f172a',
                            accent: '#3b82f6'
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Cairo', sans-serif; background-color: #f8fafc; }
        .hero-pattern {
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23d4af37' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
    </style>
</head>
<body class="antialiased text-gray-800 hero-pattern min-h-screen flex flex-col">

    <!-- Navbar -->
    <nav class="bg-brand-primary text-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <a href="{{ route('home') }}" class="text-2xl font-bold text-brand-gold tracking-wider">المنصة الوطنية</a>
                    </div>
                </div>
                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-4 space-x-reverse">
                        <a href="{{ route('home') }}" class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('home') ? 'bg-brand-dark text-white' : 'hover:text-brand-gold transition duration-300' }}">الرئيسية</a>
                        <a href="{{ route('charter') }}" class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('charter') ? 'bg-brand-dark text-white' : 'hover:text-brand-gold transition duration-300' }}">الميثاق الأخلاقي</a>
                        <a href="{{ route('legal') }}" class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('legal') ? 'bg-brand-dark text-white' : 'hover:text-brand-gold transition duration-300' }}">النصوص القانونية</a>
                         <a href="{{ route('roadmap') }}" class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('roadmap') ? 'bg-brand-dark text-white' : 'hover:text-brand-gold transition duration-300' }}">خارطة الطريق</a>
                    </div>
                </div>
                <div>
                   <!-- User requested to remove the login button -->
                </div>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <main class="flex-grow">
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="bg-brand-dark text-white mt-auto">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-6 md:mb-0 text-center md:text-right">
                    <span class="text-2xl font-bold text-brand-gold tracking-wider block">المنصة الوطنية</span>
                    <p class="mt-2 text-sm text-gray-400">للمفوضين القضائيين بالمملكة المغربية</p>
                </div>
                <div class="flex flex-wrap justify-center gap-6">
                    <a href="{{ route('home') }}" class="text-gray-400 hover:text-white transition">الرئيسية</a>
                    <a href="{{ route('charter') }}" class="text-gray-400 hover:text-white transition">الميثاق</a>
                     <a href="{{ route('legal') }}" class="text-gray-400 hover:text-white transition">القوانين</a>
                    <a href="#" class="text-gray-400 hover:text-white transition">الدعم التقني</a>
                </div>
            </div>
            <div class="mt-8 border-t border-gray-700 pt-8 text-center">
                <p class="text-sm text-gray-400">
                    &copy; {{ date('Y') }} الغرفة الوطنية للمفوضين القضائيين. جميع الحقوق محفوظة.
                </p>
            </div>
        </div>
    </footer>

</body>
</html>

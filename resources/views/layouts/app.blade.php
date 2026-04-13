<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') — LeaveTrack</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: { extend: { fontFamily: { sans: ['Inter', 'system-ui', 'sans-serif'] } } }
        }
    </script>
    <style>[x-cloak] { display: none !important; }</style>
</head>
<body class="bg-slate-50 antialiased font-sans" x-data="{ sidebarOpen: false }">
<div class="flex h-screen overflow-hidden">

    {{-- ── Mobile overlay ── --}}
    <div x-show="sidebarOpen" x-cloak @click="sidebarOpen = false"
         class="fixed inset-0 z-20 bg-black/50 lg:hidden"></div>

    {{-- ─────────────────── SIDEBAR ─────────────────── --}}
    <aside class="fixed inset-y-0 left-0 z-30 flex w-64 flex-col bg-slate-900
                  transform transition-transform duration-300 ease-in-out
                  lg:relative lg:translate-x-0"
           :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'">

        {{-- Logo --}}
        <div class="flex items-center gap-3 border-b border-white/10 px-5 py-4 shrink-0">
            <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-indigo-600">
                <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                </svg>
            </div>
            <div>
                <p class="text-sm font-semibold text-white">LeaveTrack</p>
                <p class="text-xs text-slate-400">Leave Management</p>
            </div>
        </div>

        {{-- Navigation --}}
        <nav class="flex-1 overflow-y-auto px-3 py-5 space-y-0.5">
            <p class="mb-3 px-3 text-[10px] font-semibold uppercase tracking-widest text-slate-500">Menu</p>

            @php
                $navItem = function(string $label, string $route, string $icon, string $match) { return compact('label','route','icon','match'); };
                $items = [
                    ['label'=>'Dashboard','route'=>'dashboard','match'=>'dashboard','icon'=>'<path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z" />'],
                    ['label'=>'Companies','route'=>'companies.index','match'=>'companies.*','icon'=>'<path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />'],
                    ['label'=>'Employees','route'=>'employees.index','match'=>'employees.*','icon'=>'<path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />'],
                    ['label'=>'Leave Types','route'=>'leavetypes.index','match'=>'leavetypes.*','icon'=>'<path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />'],
                    ['label'=>'Leaves','route'=>'leaves.index','match'=>'leaves.*','icon'=>'<path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />'],
                ];
            @endphp

            @foreach($items as $item)
                <a href="{{ route($item['route']) }}"
                   class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-colors
                          {{ request()->routeIs($item['match']) ? 'bg-indigo-600 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                    <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        {!! $item['icon'] !!}
                    </svg>
                    {{ $item['label'] }}
                </a>
            @endforeach
        </nav>

        {{-- User section --}}
        <div class="shrink-0 border-t border-white/10 px-3 py-3">
            <div class="flex items-center gap-3 rounded-lg px-2 py-2">
                <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-indigo-600 text-xs font-semibold text-white">
                    {{ strtoupper(substr(auth()->user()?->name ?? 'U', 0, 1)) }}
                </div>
                <div class="min-w-0 flex-1">
                    <p class="truncate text-sm font-medium text-white">{{ auth()->user()?->name }}</p>
                    <p class="truncate text-xs text-slate-400">{{ auth()->user()?->email }}</p>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" title="Sign out"
                            class="rounded-md p-1 text-slate-400 hover:text-white transition-colors">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15m-3 0-3-3m0 0 3-3m-3 3H15" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    {{-- ─────────────────── MAIN AREA ─────────────────── --}}
    <div class="flex min-w-0 flex-1 flex-col overflow-hidden">

        {{-- Top bar --}}
        <header class="flex h-14 shrink-0 items-center justify-between border-b border-slate-200 bg-white px-5">
            <div class="flex items-center gap-3">
                <button @click="sidebarOpen = !sidebarOpen"
                        class="rounded-md p-1.5 text-slate-500 hover:bg-slate-100 hover:text-slate-900 lg:hidden">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </button>
                <h1 class="text-sm font-semibold text-slate-900">@yield('title', 'Dashboard')</h1>
            </div>
            <div class="flex items-center gap-3">
                <span class="hidden text-xs text-slate-400 sm:block">{{ now()->format('D, M j Y') }}</span>
                <div class="flex h-8 w-8 items-center justify-center rounded-full bg-indigo-600 text-xs font-semibold text-white">
                    {{ strtoupper(substr(auth()->user()?->name ?? 'U', 0, 1)) }}
                </div>
            </div>
        </header>

        {{-- Scrollable content --}}
        <main class="flex-1 overflow-y-auto p-5 lg:p-7">

            @if (session('success'))
                <div class="mb-5 flex items-center gap-2.5 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3">
                    <svg class="h-4 w-4 shrink-0 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    <p class="text-sm font-medium text-emerald-800">{{ session('success') }}</p>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-5 flex items-center gap-2.5 rounded-lg border border-red-200 bg-red-50 px-4 py-3">
                    <svg class="h-4 w-4 shrink-0 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                    </svg>
                    <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
                </div>
            @endif

            @if (session('info'))
                <div class="mb-5 flex items-center gap-2.5 rounded-lg border border-indigo-200 bg-indigo-50 px-4 py-3">
                    <svg class="h-4 w-4 shrink-0 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                    </svg>
                    <p class="text-sm font-medium text-indigo-800">{{ session('info') }}</p>
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</div>
</body>
</html>

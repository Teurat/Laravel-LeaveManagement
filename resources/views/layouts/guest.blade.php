<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'LeaveTrack') — Leave Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: { extend: { fontFamily: { sans: ['Inter', 'system-ui', 'sans-serif'] } } }
        }
    </script>
</head>
<body class="font-sans antialiased">
<div class="flex min-h-screen">

    {{-- ── Left branding panel (hidden on mobile) ── --}}
    <div class="relative hidden flex-col justify-between overflow-hidden bg-gradient-to-br from-indigo-900 via-indigo-800 to-slate-900 p-12 lg:flex lg:w-[48%] xl:w-1/2">
        {{-- Subtle background decoration --}}
        <div class="absolute inset-0 opacity-[0.03]" style="background-image:radial-gradient(circle at 2px 2px,white 1px,transparent 0);background-size:40px 40px;"></div>

        {{-- Top: Logo --}}
        <div class="relative flex items-center gap-3">
            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/10 backdrop-blur">
                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                </svg>
            </div>
            <span class="text-xl font-bold text-white">LeaveTrack</span>
        </div>

        {{-- Middle: Headline --}}
        <div class="relative space-y-5">
            <h1 class="text-4xl font-bold leading-tight text-white">
                Manage employee<br>leave with ease.
            </h1>
            <p class="max-w-sm text-base leading-relaxed text-indigo-200">
                A modern leave management platform built for teams of all sizes. Track, approve, and analyse time-off in one place.
            </p>
            <ul class="mt-6 space-y-3">
                @foreach(['Manage multiple companies from one account', 'Automatic leave balance calculation', 'Real-time dashboard and analytics'] as $feat)
                    <li class="flex items-center gap-3">
                        <div class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-white/10">
                            <svg class="h-3.5 w-3.5 text-indigo-300" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                            </svg>
                        </div>
                        <span class="text-sm text-indigo-200">{{ $feat }}</span>
                    </li>
                @endforeach
            </ul>
        </div>

        {{-- Bottom: Footer --}}
        <p class="relative text-sm text-indigo-400">&copy; {{ date('Y') }} LeaveTrack. All rights reserved.</p>
    </div>

    {{-- ── Right form panel ── --}}
    <div class="flex flex-1 flex-col items-center justify-center bg-white px-6 py-12">
        <div class="w-full max-w-sm">
            {{-- Mobile logo --}}
            <div class="mb-8 flex items-center gap-2 lg:hidden">
                <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-indigo-600">
                    <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                    </svg>
                </div>
                <span class="text-xl font-bold text-slate-900">LeaveTrack</span>
            </div>

            @yield('content')
        </div>
    </div>
</div>
</body>
</html>

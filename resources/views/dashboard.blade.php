@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')

{{-- ── Stat cards ── --}}
<div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">

    <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
        <div class="flex items-start justify-between">
            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-indigo-50">
                <svg class="h-5 w-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z"/>
                </svg>
            </div>
            <span class="rounded-full bg-emerald-50 px-2 py-0.5 text-xs font-medium text-emerald-700">Active</span>
        </div>
        <p class="mt-3 text-2xl font-bold text-slate-900">{{ $totalEmployees }}</p>
        <p class="mt-0.5 text-sm text-slate-500">Total Employees</p>
    </div>

    <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
        <div class="flex items-start justify-between">
            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-violet-50">
                <svg class="h-5 w-5 text-violet-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21"/>
                </svg>
            </div>
            <span class="rounded-full bg-violet-50 px-2 py-0.5 text-xs font-medium text-violet-700">Managed</span>
        </div>
        <p class="mt-3 text-2xl font-bold text-slate-900">{{ $totalCompanies }}</p>
        <p class="mt-0.5 text-sm text-slate-500">Companies</p>
    </div>

    <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
        <div class="flex items-start justify-between">
            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-amber-50">
                <svg class="h-5 w-5 text-amber-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                </svg>
            </div>
            <span class="rounded-full bg-amber-50 px-2 py-0.5 text-xs font-medium text-amber-700">Today</span>
        </div>
        <p class="mt-3 text-2xl font-bold text-slate-900">{{ $employeesOnLeave }}</p>
        <p class="mt-0.5 text-sm text-slate-500">On Leave Today</p>
    </div>

    <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
        <div class="flex items-start justify-between">
            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-red-50">
                <svg class="h-5 w-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z"/>
                </svg>
            </div>
            @if($pendingApprovals > 0)
                <a href="{{ route('leaves.index') }}"
                   class="rounded-full bg-red-50 px-2 py-0.5 text-xs font-medium text-red-700 hover:bg-red-100 transition-colors">
                    {{ $pendingApprovals }} pending
                </a>
            @else
                <span class="rounded-full bg-emerald-50 px-2 py-0.5 text-xs font-medium text-emerald-700">All clear</span>
            @endif
        </div>
        <p class="mt-3 text-2xl font-bold text-slate-900">{{ $pendingApprovals }}</p>
        <p class="mt-0.5 text-sm text-slate-500">Pending Approvals</p>
    </div>
</div>

{{-- ── Second row ── --}}
<div class="mt-5 grid grid-cols-1 gap-5 lg:grid-cols-3">

    <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
        <div class="mb-4 flex items-center justify-between">
            <h3 class="text-sm font-semibold text-slate-900">Employees per Company</h3>
            <span class="text-xs text-slate-400">{{ $totalAnnualLeaveDays }} leave days total</span>
        </div>
        <div class="space-y-1">
            @forelse($employeesPerCompany as $companyName => $count)
                <div class="flex items-center gap-3 rounded-lg px-3 py-2 hover:bg-slate-50 transition-colors">
                    <div class="flex h-7 w-7 shrink-0 items-center justify-center rounded bg-indigo-50">
                        <svg class="h-3.5 w-3.5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m3-6H15"/>
                        </svg>
                    </div>
                    <span class="min-w-0 flex-1 truncate text-sm text-slate-700">{{ $companyName }}</span>
                    <span class="shrink-0 rounded-full bg-slate-100 px-2 py-0.5 text-xs font-semibold text-slate-700">{{ $count }}</span>
                </div>
            @empty
                <div class="py-6 text-center">
                    <p class="text-sm text-slate-400">No companies yet.</p>
                    <a href="{{ route('companies.create') }}" class="mt-1 text-sm font-medium text-indigo-600 hover:text-indigo-500">
                        Add your first company →
                    </a>
                </div>
            @endforelse
        </div>
    </div>

    <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm lg:col-span-2">
        <div class="mb-4 flex items-center justify-between">
            <h3 class="text-sm font-semibold text-slate-900">Employees Hired Per Year</h3>
            <span class="text-xs text-slate-400">Historical view</span>
        </div>
        <canvas id="hiredPerYearChart" style="max-height:220px;"></canvas>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const _data = @json($hiredPerYear);
    new Chart(document.getElementById('hiredPerYearChart'), {
        type: 'bar',
        data: {
            labels: _data.map(d => d.year),
            datasets: [{ label: 'Hired', data: _data.map(d => d.count),
                backgroundColor: 'rgba(99,102,241,0.12)', borderColor: 'rgba(99,102,241,1)',
                borderWidth: 2, borderRadius: 6, borderSkipped: false }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, grid: { color: 'rgba(148,163,184,0.1)' }, ticks: { color: '#94a3b8', font: { size: 11 } } },
                x: { grid: { display: false }, ticks: { color: '#94a3b8', font: { size: 11 } } }
            }
        }
    });
</script>
@endsection

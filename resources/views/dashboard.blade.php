@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">

    <div class="p-4 bg-green-100 rounded shadow hover:shadow-lg transition transform hover:scale-105">
        <div class="flex items-center">
            <div class="p-2 bg-green-500 text-white rounded-full">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M17 20h5v-2a4 4 0 00-4-4h-1M9 20H4v-2a4 4 0 014-4h1m0-4a4 4 0 118 0 4 4 0 01-8 0z"/>
                </svg>
            </div>
            <div class="ml-4">
                <h2 class="text-lg font-semibold">Total Employees</h2>
                <p class="text-2xl font-bold">{{ $totalEmployees }}</p>
            </div>
        </div>
    </div>

    <div class="p-4 bg-blue-100 rounded shadow hover:shadow-lg transition transform hover:scale-105 col-span-1 md:col-span-2">
        <div class="flex items-center mb-2">
            <div class="p-2 bg-blue-500 text-white rounded-full">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M4 21h16M4 10h16M10 21V3m4 0v18"/>
                </svg>
            </div>
            <h2 class="ml-4 text-lg font-semibold">Employees per Company</h2>
        </div>
        <ul>
            @foreach ($employeesPerCompany as $companyName => $count)
                <li class="flex justify-between border-b py-1">
                    <span>{{ $companyName }}</span>
                    <span class="font-bold">{{ $count }}</span>
                </li>
            @endforeach
        </ul>
    </div>

    <div class="p-4 bg-yellow-100 rounded shadow hover:shadow-lg transition transform hover:scale-105">
        <div class="flex items-center">
            <div class="p-2 bg-yellow-500 text-white rounded-full">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7H3v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <div class="ml-4">
                <h2 class="text-lg font-semibold">Total Annual Leave Days</h2>
                <p class="text-2xl font-bold">{{ $totalAnnualLeaveDays }}</p>
            </div>
        </div>
    </div>

    <div class="p-4 bg-purple-100 rounded shadow hover:shadow-lg transition transform hover:scale-105">
        <div class="flex items-center">
            <div class="p-2 bg-purple-500 text-white rounded-full">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M10.5 12H3m9.5 0L21 3m0 0v6m0-6h-6"/>
                </svg>
            </div>
            <div class="ml-4">
                <h2 class="text-lg font-semibold">Employees Currently on Leave</h2>
                <p class="text-2xl font-bold">{{ $employeesOnLeave }}</p>
            </div>
        </div>
    </div>

    <div class="p-4 bg-red-100 rounded shadow hover:shadow-lg transition transform hover:scale-105">
        <div class="flex items-center">
            <div class="p-2 bg-red-500 text-white rounded-full">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" 
                    stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="ml-4">
                <h2 class="text-lg font-semibold">Pending Approvals</h2>
                <p class="text-2xl font-bold">{{ $pendingApprovals }}</p>
            </div>
        </div>
    </div>
</div>


<div class="p-6 bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
    <h2 class="text-xl font-semibold mb-6 text-gray-800">Employees Hired Per Year</h2>
    <canvas id="hiredPerYearChart" class="w-full" style="max-height: 300px;"></canvas>
</div>



<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const hiredPerYearData = @json($hiredPerYear);

    const labels = hiredPerYearData.map(item => item.year);
    const dataCounts = hiredPerYearData.map(item => item.count);

    const ctx = document.getElementById('hiredPerYearChart').getContext('2d');

    const hiredPerYearChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Employees Hired',
                data: dataCounts,
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
</script>
@endsection

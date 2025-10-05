@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <!-- Greeting Card Custom -->
        <div class="col-12">
            <div class="card shadow-sm" style="border-radius: 18px; background: #fff;">
                <div class="card-body p-3 p-md-4">
                    <div class="row align-items-center">
                        <!-- Left: Profile Image -->
                        <div class="col-12 col-md-auto text-center mb-3 mb-md-0">
                            <div class="mx-auto" style="width: 100px; height: 100px; border-radius: 50%; overflow: hidden; background: #f3f3f3;">
                                <img src="{{ Auth::user()->foto_profil ? asset('storage/' . Auth::user()->foto_profil) : asset('img/orang.png') }}"
                                     alt="Profile" style="width: 100%; height: 100%; object-fit: cover; object-position: center;">
                            </div>
                        </div>

                        <!-- Center: Greeting -->
                        <div class="col-12 col-md px-md-4 text-center text-md-start mb-3 mb-md-0">
                            <div class="mb-2">
                                <div class="d-inline-flex align-items-center bg-light px-3 py-1 rounded-pill">
                                    <i class="bi bi-calendar-date me-2"></i>
                                    <span id="currentDateTime"></span>
                                </div>
                            </div>
                            <h1 class="fw-bold mb-0" style="font-size: calc(1.8rem + 1vw);">Good Morning,<br>{{ Auth::user()->nama }} !</h1>
                            <div class="mt-2 text-muted">Have nice <span id="currentDay"></span></div>
                        </div>

                        <!-- Right: Peringatan Card -->
                        <div class="col-12 col-md-auto" style="min-width: 280px; max-width: 100%;">
                            <div class="card shadow-sm border-0" style="border-radius: 14px;">
                                <div class="card-body p-3">
                                    <div class="d-flex align-items-center mb-3">
                                        <i class="bi bi-exclamation-triangle-fill text-danger me-2" style="font-size: 1.3rem;"></i>
                                        <span class="fw-bold" style="font-size: 1.1rem;">Peringatan Dosis</span>
                                    </div>
                                    <div class="dosis-warning-list">
                                        @forelse($peringatanDosis as $peringatan)
                                            <div class="d-flex align-items-center justify-content-between mb-2 notification-item" style="background: #ffebee; border-radius: 8px; padding: 6px 12px;">
                                                <span class="text-danger text-truncate me-2" style="font-size: 0.9rem;">{{ $peringatan->nama }}</span>
                                                <span class="badge bg-danger text-white fw-semibold" style="font-size: 0.85rem; white-space: nowrap;">
                                                    {{ number_format($peringatan->totalDosis / 1000, 3) }} mSv
                                                </span>
                                            </div>
                                        @empty
                                            <div class="text-muted text-center py-2" style="font-size: 0.9rem;">
                                                <i class="bi bi-check-circle-fill text-success me-1"></i> Semua dosis pekerja dalam batas aman.
                                            </div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <a href="{{ route('admin.kelola_akun') }}" class="text-decoration-none">
                <div class="stat-card d-flex align-items-center justify-content-center h-100 p-3" style="background: #0d2c54; color: #fff; border-radius: 15px; min-height: 70px;">
                    <i class="bi bi-person" style="font-size: 1.5rem;"></i>
                    <span class="fw-bold ms-2 text-truncate" style="font-size: 0.9rem;">Daftar Pekerja</span>
                </div>
            </a>
        </div>
        <div class="col-6 col-md-3">
            <a href="{{ route('admin.perizinan.index') }}" class="text-decoration-none">
                <div class="stat-card d-flex align-items-center justify-content-center h-100 p-3" style="background: #0d2c54; color: #fff; border-radius: 15px; min-height: 70px;">
                    <i class="bi bi-radioactive" style="font-size: 1.5rem;"></i>
                    <span class="fw-bold ms-2 text-truncate" style="font-size: 0.9rem;">Daftar Sumber</span>
                </div>
            </a>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card d-flex flex-column align-items-center justify-content-center h-100 p-3" style="background: #fff; color: #0d2c54; border-radius: 15px; min-height: 70px;">
                <div class="d-flex align-items-center mb-1">
                    <i class="bi bi-radioactive" style="font-size: 1.2rem;"></i>
                    <span class="fw-bold ms-2 text-truncate" style="font-size: 0.85rem;">Data Dosis Bulan Ini</span>
                </div>
                <span class="fw-bold" style="font-size: 1.1rem;">10</span>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card d-flex flex-column align-items-center justify-content-center h-100 p-3" style="background: #fff; color: #0d2c54; border-radius: 15px; min-height: 70px;">
                <div class="d-flex align-items-center mb-1">
                    <i class="bi bi-people-fill" style="font-size: 1.2rem;"></i>
                    <span class="fw-bold ms-2 text-truncate" style="font-size: 0.85rem;">Total Pekerja</span>
                </div>
                <span class="fw-bold" style="font-size: 1.1rem;">{{ number_format($totalPekerja) }}</span>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Chart Card -->
        <div class="col-12 col-lg-8">
            <div class="card text-white h-100" style="background-color: #0d2c54; border-radius: 10px;">
                <div class="card-body p-3 p-md-4">
                    <h5 class="fw-bold mb-4">Grafik Tren Dosis</h5>
                    <div style="height: 300px;">
                        <canvas id="doseChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Calendar Card -->
        <div class="col-12 col-lg-4">
            <div class="card text-white h-100" style="background-color: #0d2c54; border-radius: 10px;">
                <div class="card-body p-3 p-md-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <a href="#" class="text-white opacity-50" id="prevMonth"><i class="bi bi-chevron-left"></i></a>
                        <h6 class="fw-bold mb-0" id="currentMonthYear"></h6>
                        <a href="#" class="text-white opacity-50" id="nextMonth"><i class="bi bi-chevron-right"></i></a>
                    </div>

                    <div class="row text-center mb-2 small">
                        <div class="col px-1">S</div>
                        <div class="col px-1">M</div>
                        <div class="col px-1">T</div>
                        <div class="col px-1">W</div>
                        <div class="col px-1">T</div>
                        <div class="col px-1">F</div>
                        <div class="col px-1">S</div>
                    </div>

                    <div id="calendarGrid" class="calendar-grid">
                        <!-- Calendar grid will be generated dynamically by JS -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap CSS dan Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
.dosis-warning-list {
    max-height: 120px;
    overflow-y: auto;
}
.dosis-warning-list::-webkit-scrollbar {
    width: 5px;
}
.dosis-warning-list::-webkit-scrollbar-track {
    background: #f1f1f1;
}
.dosis-warning-list::-webkit-scrollbar-thumb {
    background: #ccc;
    border-radius: 5px;
}
.bg-dark-blue {
    background-color: #0d2c54;
}

.calendar-grid .col {
    padding: 4px 2px;
}

.calendar-day {
    width: 24px;
    height: 24px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    cursor: pointer;
    transition: all 0.2s;
}

.calendar-day:hover {
    background-color: rgba(255, 255, 255, 0.1);
}

.calendar-day.current {
    background-color: #3498db;
}

.calendar-day.other-month {
    opacity: 0.3;
}

.donut-chart {
    position: relative;
    width: 160px;
    height: 160px;
    margin: 0 auto;
}

.d-flex.align-items-center.justify-content-center:hover {
    box-shadow: 0 4px 16px rgba(13,44,84,0.15);
    background: #143d6b;
    color: #fff;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    function updateDateTime() {
        const now = new Date();
        // Format date: Month DD
        const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        const month = months[now.getMonth()];
        const date = now.getDate();
        const year = now.getFullYear();
        document.getElementById('currentDateTime').textContent = `${month} ${date}, ${year}`;
        // Day for greeting
        const days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        const day = days[now.getDay()];
        document.getElementById('currentDay').textContent = day;
    }
    updateDateTime();
    setInterval(updateDateTime, 1000);
    
    // Calendar functionality
    let currentDate = new Date();
    let currentMonth = currentDate.getMonth();
    let currentYear = currentDate.getFullYear();
    
    function updateCalendar() {
        // Update month and year display
        const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        document.getElementById('currentMonthYear').textContent = `${months[currentMonth]} ${currentYear}`;
        
        // Get the first day of the month (0-6, where 0 is Sunday)
        const firstDay = new Date(currentYear, currentMonth, 1).getDay();
        
        // Get the number of days in the month
        const daysInMonth = new Date(currentYear, currentMonth + 1, 0).getDate();
        
        // Get the number of days in the previous month
        const daysInPrevMonth = new Date(currentYear, currentMonth, 0).getDate();
        
        // Generate the calendar grid
        let calendarHtml = '';
        
        let dayCounter = 1;
        let nextMonthCounter = 1;
        
        // Calculate the number of rows needed
        const numRows = Math.ceil((firstDay + daysInMonth) / 7);
        
        // Create the calendar rows
        for (let row = 0; row < numRows; row++) {
            calendarHtml += '<div class="row text-center small mb-2">';
            
            // Create the cells for each day
            for (let col = 0; col < 7; col++) {
                // Determine if this cell is for the current month, previous month, or next month
                if (row === 0 && col < firstDay) {
                    // Previous month
                    const prevDay = daysInPrevMonth - (firstDay - col - 1);
                    calendarHtml += `<div class="col"><span class="calendar-day other-month">${prevDay}</span></div>`;
                } else if (dayCounter > daysInMonth) {
                    // Next month
                    calendarHtml += `<div class="col"><span class="calendar-day other-month">${nextMonthCounter}</span></div>`;
                    nextMonthCounter++;
                } else {
                    // Current month
                    const today = new Date();
                    const isToday = dayCounter === today.getDate() && 
                                    currentMonth === today.getMonth() && 
                                    currentYear === today.getFullYear();
                    
                    if (isToday) {
                        calendarHtml += `<div class="col"><span class="calendar-day current">${dayCounter}</span></div>`;
                    } else {
                        calendarHtml += `<div class="col"><span class="calendar-day">${dayCounter}</span></div>`;
                    }
                    dayCounter++;
                }
            }
            
            calendarHtml += '</div>';
        }
        
        document.getElementById('calendarGrid').innerHTML = calendarHtml;
    }
    
    // Event listeners for month navigation
    document.getElementById('prevMonth').addEventListener('click', function(e) {
        e.preventDefault();
        currentMonth--;
        if (currentMonth < 0) {
            currentMonth = 11;
            currentYear--;
        }
        updateCalendar();
    });
    
    document.getElementById('nextMonth').addEventListener('click', function(e) {
        e.preventDefault();
        currentMonth++;
        if (currentMonth > 11) {
            currentMonth = 0;
            currentYear++;
        }
        updateCalendar();
    });
    
    // Initialize calendar
    updateCalendar();
    
    // Chart untuk Grafik Tren Dosis
    const doseCtx = document.getElementById('doseChart').getContext('2d');
    const doseChart = new Chart(doseCtx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                label: 'Dosis 1',
                data: [180, 240, 200, 280, 300, 270, 240, 230, 150, 190, 170, 240],
                borderColor: '#3498db',
                backgroundColor: 'rgba(52, 152, 219, 0.1)',
                borderWidth: 3,
                tension: 0.4,
                fill: true
            }, {
                label: 'Dosis 2',
                data: [400, 220, 180, 250, 320, 400, 380, 320, 300, 350, 220, 380],
                borderColor: '#b2bec3',
                backgroundColor: 'rgba(178, 190, 195, 0.1)',
                borderWidth: 3,
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            },
            responsive: true,
            maintainAspectRatio: false
        }
    });

    // Chart untuk Statistik Kunjungan
    const visitCtx = document.getElementById('visitChart').getContext('2d');
    const visitChart = new Chart(visitCtx, {
        type: 'doughnut',
        data: {
            labels: ['Completed'],
            datasets: [{
                data: [100],
                backgroundColor: ['#3498db'],
                borderWidth: 0,
                cutout: '80%'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
});
</script>
@endsection
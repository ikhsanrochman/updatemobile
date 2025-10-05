@extends('layouts.user')

@section('content')
<div class="container-fluid py-4" style="background:#f6f8fa; min-height:100vh;">
    <div class="row g-4 mb-4">
        <!-- Greeting Card -->
        <div class="col-lg-8">
            <div class="card shadow-sm" style="border-radius:18px;">
                <div class="card-body d-flex align-items-center" style="min-height:180px;">
                    <div class="me-4">
                        <img src="{{ Auth::user()->foto_profil ? asset('storage/' . Auth::user()->foto_profil) : asset('img/orang.png') }}" alt="Profile" style="width:90px; height:90px; object-fit:cover; border-radius:50%;">
                    </div>
                    <div class="flex-grow-1">
                        <h2 class="fw-bold mb-1" style="font-size:2rem;">Hello, {{ Auth::user()->nama }}!</h2>
                        <div class="text-muted" style="font-size:1rem;">Selamat datang kembali di dasbor Anda.</div>
                         <div class="text-muted mt-2" style="font-size:0.9rem;"><i class="bi bi-calendar-week me-2"></i><span id="currentDateTime"></span></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Dosis Saat Ini -->
        <div class="col-lg-4">
            <div class="card shadow-sm h-100" style="border-radius:18px;">
                <div class="card-body d-flex flex-column justify-content-center text-center">
                    <div class="fw-semibold text-muted mb-2">Total Akumulasi Dosis</div>
                    <div class="display-4 fw-bold mb-2">
                        {{ number_format($totalDosis / 1000, 4) }}
                    </div>
                    <div class="text-muted">mSv</div>
                    <div class="mt-3" style="min-height: 28px;">
                        @if (($totalDosis / 1000) > 20)
                            <div class="small px-3 py-1 rounded-pill d-inline-block" style="background-color: #ffebee; color: #c62828; font-weight:500;">
                                <i class="bi bi-exclamation-triangle-fill me-1"></i> Batas dosis terlampaui!
                            </div>
                        @else
                            <div class="small px-3 py-1 rounded-pill d-inline-block" style="background-color: #e8f5e9; color: #388e3c; font-weight:500;">
                                <i class="bi bi-check-circle-fill me-1"></i> Masih dalam batas aman
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row g-4 mb-4">
        <!-- Dosis TLD -->
        <div class="col-lg-6">
            <div class="card shadow-sm h-100" style="border-radius:18px;">
                <div class="card-body d-flex flex-column">
                    <div class="fw-bold mb-3 d-flex align-items-center" style="font-size:1.2rem;">
                        <i class="bi bi-credit-card-2-front me-2"></i> Riwayat Dosis TLD
                    </div>
                    <div class="dosis-list-wrapper flex-grow-1">
                        @forelse($allDosisTld as $dosis)
                        <div class="d-flex justify-content-between align-items-center py-2 px-1 border-bottom-dashed">
                            <div>
                                <div class="fw-semibold text-dark">Periode #{{ $loop->iteration }}</div>
                                <div class="small text-muted">{{ \Carbon\Carbon::parse($dosis->tanggal_pemantauan)->subMonths(3)->format('d M Y') }} - {{ \Carbon\Carbon::parse($dosis->tanggal_pemantauan)->format('d M Y') }}</div>
                            </div>
                            <div class="fw-bold text-dark" style="font-size:1.1rem;">{{ number_format($dosis->dosis / 1000, 4) }} mSv</div>
                        </div>
                        @empty
                        <div class="text-center text-muted py-5 h-100 d-flex flex-column justify-content-center align-items-center">
                            <i class="bi bi-x-circle fs-2"></i>
                            <div class="mt-2">Tidak ada data TLD.</div>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
        <!-- Dosis Pendos -->
        <div class="col-lg-6">
            <div class="card shadow-sm h-100" style="border-radius:18px;">
                <div class="card-body d-flex flex-column">
                    <div class="fw-bold mb-3 d-flex align-items-center" style="font-size:1.2rem;">
                        <i class="bi bi-calculator-fill me-2"></i> Riwayat Dosis Pendos
                    </div>
                    <div class="dosis-list-wrapper flex-grow-1">
                        @forelse($allDosisPendose as $dosis)
                        <div class="d-flex justify-content-between align-items-center py-2 px-1 border-bottom-dashed">
                            <div>
                                <div class="fw-semibold text-dark">{{ $dosis->jenis_alat_pemantauan }}</div>
                                <div class="small text-muted">{{ \Carbon\Carbon::parse($dosis->tanggal_pengukuran)->format('d M Y') }}</div>
                            </div>
                            <div class="fw-bold text-dark" style="font-size:1.1rem;">{{ number_format($dosis->hasil_pengukuran / 1000, 4) }} mSv</div>
                        </div>
                        @empty
                        <div class="text-center text-muted py-5 h-100 d-flex flex-column justify-content-center align-items-center">
                            <i class="bi bi-x-circle fs-2"></i>
                            <div class="mt-2">Tidak ada data pendos.</div>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
body { background: #ffffff; }
.card { border: none; }
.border-bottom-dashed {
    border-bottom: 1px dashed #e0e0e0;
}
.dosis-list-wrapper .border-bottom-dashed:last-child {
    border-bottom: none;
}
.dosis-list-wrapper {
    overflow-y: auto;
    flex-grow: 1;
}
.dosis-list-wrapper::-webkit-scrollbar {
    width: 5px;
}
.dosis-list-wrapper::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}
.dosis-list-wrapper::-webkit-scrollbar-thumb {
    background-color: #ccc;
    border-radius: 10px;
}
</style>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Date & Day
    function updateDateTime() {
        const now = new Date();
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit' };
        document.getElementById('currentDateTime').textContent = now.toLocaleDateString('id-ID', options);
    }
    updateDateTime();
    setInterval(updateDateTime, 1000);
});
</script>
@endpush
@endsection
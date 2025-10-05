@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title fw-semibold mb-4">Pengangkutan Sumber Radioaktif</h5>
                    
                    <form action="#" method="POST">
                        @csrf
                        <!-- Informasi Dasar -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Tanggal dan Waktu Pengangkutan (keberangkatan)</label>
                                    <input type="datetime-local" class="form-control" name="waktu_berangkat">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Lokasi pekerjaan</label>
                                    <input type="text" class="form-control" name="lokasi_pekerjaan">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Estimasi Lama Perjalanan</label>
                                    <input type="text" class="form-control" name="estimasi_perjalanan">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Tanggal dan Waktu Pengangkutan (kedatangan)</label>
                                    <input type="datetime-local" class="form-control" name="waktu_datang">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Jarak (dari Bunker Kantor)</label>
                                    <input type="text" class="form-control" name="jarak">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Jenis Moda Angkutan</label>
                                    <input type="text" class="form-control" name="jenis_moda">
                                </div>
                            </div>
                        </div>

                        <!-- Petugas -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h6 class="mb-3">Nama Petugas Radiografi</h6>
                                <div class="mb-2">
                                    <input type="text" class="form-control mb-2" name="radiografi[]" placeholder="Petugas 1">
                                    <input type="text" class="form-control mb-2" name="radiografi[]" placeholder="Petugas 2">
                                    <input type="text" class="form-control mb-2" name="radiografi[]" placeholder="Petugas 3">
                                    <input type="text" class="form-control" name="radiografi[]" placeholder="Petugas 4">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h6 class="mb-3">Nama Petugas Proteksi</h6>
                                <div class="mb-2">
                                    <input type="text" class="form-control mb-2" name="proteksi[]" placeholder="Petugas 1">
                                    <input type="text" class="form-control" name="proteksi[]" placeholder="Petugas 2">
                                </div>
                            </div>
                        </div>

                        <!-- Pengukuran -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h6 class="mb-3">Pengukuran pada permukaan moda angkutan (μSv/jam)</h6>
                                <div class="mb-3">
                                    <label class="form-label">Depan</label>
                                    <input type="number" step="0.01" class="form-control" name="ukur_depan">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Belakang</label>
                                    <input type="number" step="0.01" class="form-control" name="ukur_belakang">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Kanan</label>
                                    <input type="number" step="0.01" class="form-control" name="ukur_kanan">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Kiri</label>
                                    <input type="number" step="0.01" class="form-control" name="ukur_kiri">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h6 class="mb-3">Nomor Sertifikat</h6>
                                <div class="mb-3">
                                    <label class="form-label">Izin Pengangkutan</label>
                                    <input type="text" class="form-control" name="no_izin">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Petugas Radiografi</label>
                                    <input type="text" class="form-control" name="no_radiografi">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Petugas Proteksi</label>
                                    <input type="text" class="form-control" name="no_proteksi">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Petugas Keamanan</label>
                                    <input type="text" class="form-control" name="no_keamanan">
                                </div>
                            </div>
                        </div>

                        <!-- Peralatan -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="mb-3">Peralatan</h6>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Peralatan</th>
                                                <th style="width: 100px">Cek</th>
                                                <th style="width: 150px">Jumlah</th>
                                                <th>Keterangan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach(['Surveymeter', 'Pendos', 'TLD', 'Kontainer Sumber', 'Kontainer Transport', 
                                                     'Penjepit Tangkai Panjang', 'Plat PB', 'Tang Potong Panjang', 
                                                     'Gembok Ber-Alarm', 'Alat komunikasi', 'Senter Besar'] as $alat)
                                            <tr>
                                                <td>{{ $alat }}</td>
                                                <td>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="cek_{{ Str::slug($alat) }}">
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control" name="jumlah_{{ Str::slug($alat) }}">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" name="ket_{{ Str::slug($alat) }}">
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Rencana Pengangkutan -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="mb-3">Rencana Pengangkutan</h6>
                                @foreach(range('a', 'g') as $index)
                                <div class="mb-2">
                                    <input type="text" class="form-control" name="rencana[]" placeholder="Rencana {{ strtoupper($index) }}">
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Kegiatan Pengangkutan -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="mb-3">Kegiatan Pengangkutan</h6>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="tabelKegiatan">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Tanggal</th>
                                                <th>Waktu</th>
                                                <th>Tempat</th>
                                                <th>Depan</th>
                                                <th>Belakang</th>
                                                <th>Kanan</th>
                                                <th>Kiri</th>
                                                <th>Pengemudi</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td><input type="date" class="form-control" name="keg_tanggal[]"></td>
                                                <td><input type="time" class="form-control" name="keg_waktu[]"></td>
                                                <td><input type="text" class="form-control" name="keg_tempat[]"></td>
                                                <td><input type="number" step="0.01" class="form-control" name="keg_depan[]"></td>
                                                <td><input type="number" step="0.01" class="form-control" name="keg_belakang[]"></td>
                                                <td><input type="number" step="0.01" class="form-control" name="keg_kanan[]"></td>
                                                <td><input type="number" step="0.01" class="form-control" name="keg_kiri[]"></td>
                                                <td><input type="text" class="form-control" name="keg_pengemudi[]"></td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-success" onclick="tambahBaris()">+</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Total Pengukuran -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="mb-3">Total Pengukuran Dosis Selama Pengangkutan</h6>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="tabelDosis">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama</th>
                                                <th>Dosis dari PenDos (μSv)</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td><input type="text" class="form-control" name="dosis_nama[]"></td>
                                                <td><input type="number" step="0.01" class="form-control" name="dosis_nilai[]"></td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-success" onclick="tambahBarisDosis()">+</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Persetujuan -->
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <h6 class="mb-3">Diperiksakan oleh (Petugas Proteksi Lapangan)</h6>
                                <div class="mb-3">
                                    <label class="form-label">Nama</label>
                                    <input type="text" class="form-control" name="nama_pemeriksa">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Tanda Tangan</label>
                                    <input type="text" class="form-control" name="ttd_pemeriksa">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <h6 class="mb-3">Disetujui oleh (Petugas Proteksi Kantor)</h6>
                                <div class="mb-3">
                                    <label class="form-label">Nama</label>
                                    <input type="text" class="form-control" name="nama_setuju">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Tanda Tangan</label>
                                    <input type="text" class="form-control" name="ttd_setuju">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <h6 class="mb-3">Diawasi oleh (Manager Operasional)</h6>
                                <div class="mb-3">
                                    <label class="form-label">Nama</label>
                                    <input type="text" class="form-control" name="nama_pengawas">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Tanda Tangan</label>
                                    <input type="text" class="form-control" name="ttd_pengawas">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Simpan Data</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function tambahBaris() {
        const tbody = document.querySelector('#tabelKegiatan tbody');
        const newRow = tbody.insertRow();
        const rowCount = tbody.rows.length;
        
        newRow.innerHTML = `
            <td>${rowCount}</td>
            <td><input type="date" class="form-control" name="keg_tanggal[]"></td>
            <td><input type="time" class="form-control" name="keg_waktu[]"></td>
            <td><input type="text" class="form-control" name="keg_tempat[]"></td>
            <td><input type="number" step="0.01" class="form-control" name="keg_depan[]"></td>
            <td><input type="number" step="0.01" class="form-control" name="keg_belakang[]"></td>
            <td><input type="number" step="0.01" class="form-control" name="keg_kanan[]"></td>
            <td><input type="number" step="0.01" class="form-control" name="keg_kiri[]"></td>
            <td><input type="text" class="form-control" name="keg_pengemudi[]"></td>
            <td>
                <button type="button" class="btn btn-sm btn-danger" onclick="this.closest('tr').remove()">-</button>
            </td>
        `;
    }

    function tambahBarisDosis() {
        const tbody = document.querySelector('#tabelDosis tbody');
        const newRow = tbody.insertRow();
        const rowCount = tbody.rows.length;
        
        newRow.innerHTML = `
            <td>${rowCount}</td>
            <td><input type="text" class="form-control" name="dosis_nama[]"></td>
            <td><input type="number" step="0.01" class="form-control" name="dosis_nilai[]"></td>
            <td>
                <button type="button" class="btn btn-sm btn-danger" onclick="this.closest('tr').remove()">-</button>
            </td>
        `;
    }
</script>
@endpush

@endsection 
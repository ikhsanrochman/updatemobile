<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Detail Proyek - {{ $project->nama_proyek }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #1e3a5f;
            padding-bottom: 20px;
        }
        
        .header h1 {
            color: #1e3a5f;
            margin: 0;
            font-size: 24px;
        }
        
        .header p {
            margin: 5px 0;
            color: #666;
        }
        
        .project-info {
            margin-bottom: 30px;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 15px;
            background-color: #f9f9f9;
        }
        
        .project-info h2 {
            color: #1e3a5f;
            margin-top: 0;
            font-size: 18px;
            border-bottom: 1px solid #1e3a5f;
            padding-bottom: 5px;
        }
        
        .info-grid {
            display: table;
            width: 100%;
        }
        
        .info-row {
            display: table-row;
        }
        
        .info-label {
            display: table-cell;
            font-weight: bold;
            width: 30%;
            padding: 5px;
        }
        
        .info-value {
            display: table-cell;
            padding: 5px;
        }
        
        .section {
            margin-bottom: 30px;
            page-break-inside: avoid;
        }
        
        .section h3 {
            color: #1e3a5f;
            background-color: #1e3a5f;
            color: white;
            padding: 10px;
            margin: 0;
            font-size: 16px;
        }
        
        .table-container {
            border: 1px solid #ddd;
            margin-top: 10px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
        }
        
        th {
            background-color: #1e3a5f;
            color: white;
            padding: 8px;
            text-align: left;
            font-weight: bold;
        }
        
        td {
            padding: 6px 8px;
            border-bottom: 1px solid #ddd;
        }
        
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        
        .no-data {
            text-align: center;
            padding: 20px;
            color: #666;
            font-style: italic;
        }
        
        .page-break {
            page-break-before: always;
        }
        
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN DETAIL PROYEK</h1>
        <p>Sistem Informasi Pemantauan Dosis Radiasi (SIPEMDORA)</p>
        <p>Tanggal Laporan: {{ date('d/m/Y H:i') }}</p>
    </div>

    <div class="project-info">
        <h2>Informasi Proyek</h2>
        <div class="info-grid">
            <div class="info-row">
                <div class="info-label">Nama Proyek:</div>
                <div class="info-value">{{ $project->nama_proyek }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Tanggal Mulai:</div>
                <div class="info-value">{{ $project->tanggal_mulai ? $project->tanggal_mulai->format('d/m/Y') : '-' }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Tanggal Selesai:</div>
                <div class="info-value">{{ $project->tanggal_selesai ? $project->tanggal_selesai->format('d/m/Y') : '-' }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Durasi:</div>
                <div class="info-value">
                    @if($project->tanggal_mulai && $project->tanggal_selesai)
                        {{ $project->tanggal_mulai->diffInDays($project->tanggal_selesai) }} hari
                    @else
                        -
                    @endif
                </div>
            </div>
            <div class="info-row">
                <div class="info-label">Status:</div>
                <div class="info-value">
                    @if($project->tanggal_mulai && $project->tanggal_selesai)
                        @if($project->tanggal_selesai->isPast())
                            Selesai
                        @elseif($project->tanggal_mulai->isPast() && $project->tanggal_selesai->isFuture())
                            Berlangsung
                        @else
                            Belum Dimulai
                        @endif
                    @else
                        Tidak Diketahui
                    @endif
                </div>
            </div>
            <div class="info-row">
                <div class="info-label">Keterangan:</div>
                <div class="info-value">{{ $project->keterangan ?: '-' }}</div>
            </div>
        </div>
    </div>

    <!-- Perizinan Section -->
    <div class="section">
        <h3>Data Perizinan Sumber Radiasi Pengion</h3>
        <div class="table-container">
            @if($project->perizinanSumberRadiasiPengion->count() > 0)
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Tipe</th>
                            <th>No Seri</th>
                            <th>Aktivitas</th>
                            <th>No KTUN</th>
                            <th>Tanggal Berlaku</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($project->perizinanSumberRadiasiPengion as $perizinan)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $perizinan->nama }}</td>
                            <td>{{ $perizinan->tipe }}</td>
                            <td>{{ $perizinan->no_seri }}</td>
                            <td>{{ $perizinan->aktivitas }}</td>
                            <td>{{ $perizinan->no_ktun }}</td>
                            <td>{{ $perizinan->tanggal_berlaku ? $perizinan->tanggal_berlaku->format('d/m/Y') : '-' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="no-data">Belum ada data perizinan untuk proyek ini</div>
            @endif
        </div>
    </div>

    <!-- SDM Section -->
    <div class="section">
        <h3>Data Ketersediaan SDM</h3>
        <div class="table-container">
            @if($project->ketersediaanSdm->count() > 0)
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>NPR</th>
                            <th>Username</th>
                            <th>Jenis Pekerja</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $counter = 1; @endphp
                        @foreach($project->ketersediaanSdm as $sdm)
                            @if($sdm->users && $sdm->users->count() > 0)
                                @foreach($sdm->users as $user)
                                <tr>
                                    <td>{{ $counter++ }}</td>
                                    <td>{{ $user->nama ?? '-' }}</td>
                                    <td>{{ $user->npr ?? '-' }}</td>
                                    <td>{{ $user->username ?? '-' }}</td>
                                    <td>
                                        @if($user->jenisPekerja && $user->jenisPekerja->count() > 0)
                                            {{ $user->jenisPekerja->first()->nama ?? '-' }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            @endif
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="no-data">Belum ada data SDM untuk proyek ini</div>
            @endif
        </div>
    </div>

    <!-- TLD Section -->
    <div class="section">
        <h3>Data Pemantauan Dosis TLD</h3>
        @php
            // Get all user IDs from project's SDM
            $projectUserIds = [];
            foreach($project->ketersediaanSdm as $sdm) {
                if($sdm->users) {
                    foreach($sdm->users as $user) {
                        $projectUserIds[] = $user->id;
                    }
                }
            }
            
            // Filter TLD data to only show records for project SDM users
            $filteredTldData = $project->pemantauanDosisTld->filter(function($tld) use ($projectUserIds) {
                return in_array($tld->user_id, $projectUserIds);
            });
        @endphp
        
        @if($filteredTldData->count() > 0)
            @php
                // Group TLD data by user
                $tldDataByUser = $filteredTldData->groupBy('user_id');
            @endphp
            
            @foreach($tldDataByUser as $userId => $userTldData)
                @php $user = $userTldData->first()->user; @endphp
                <div class="table-container" style="margin-bottom: 20px;">
                    <h4 style="color: #1e3a5f; margin-bottom: 10px; font-size: 14px;">SDM: {{ $user->nama ?? '-' }} (NPR: {{ $user->npr ?? '-' }})</h4>
                    <table>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal Pemantauan</th>
                                <th>Dosis</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($userTldData->sortBy('tanggal_pemantauan') as $tld)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $tld->tanggal_pemantauan ? $tld->tanggal_pemantauan->format('d/m/Y') : '-' }}</td>
                                <td>{{ $tld->dosis }}</td>
                                <td>{{ $tld->keterangan ?: '-' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endforeach
        @else
            <div class="no-data">Belum ada data pemantauan TLD untuk SDM proyek ini</div>
        @endif
    </div>

    <!-- Pendose Section -->
    <div class="section">
        <h3>Data Pemantauan Dosis Pendose</h3>
        @php
            // Filter Pendose data to only show records for project SDM users
            $filteredPendoseData = $project->pemantauanDosisPendose->filter(function($pendose) use ($projectUserIds) {
                return in_array($pendose->user_id, $projectUserIds);
            });
        @endphp
        
        @if($filteredPendoseData->count() > 0)
            @php
                // Group Pendose data by user
                $pendoseDataByUser = $filteredPendoseData->groupBy('user_id');
            @endphp
            
            @foreach($pendoseDataByUser as $userId => $userPendoseData)
                @php $user = $userPendoseData->first()->user; @endphp
                <div class="table-container" style="margin-bottom: 20px;">
                    <h4 style="color: #1e3a5f; margin-bottom: 10px; font-size: 14px;">SDM: {{ $user->nama ?? '-' }} (NPR: {{ $user->npr ?? '-' }})</h4>
                    <table>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>NPR</th>
                                <th>Jenis Alat Pemantauan</th>
                                <th>Hasil Pengukuran</th>
                                <th>Tanggal Pengukuran</th>
                                <th>Kartu Dosis</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($userPendoseData->sortBy('tanggal_pengukuran') as $pendose)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $pendose->npr ?? '-' }}</td>
                                <td>{{ $pendose->jenis_alat_pemantauan ?? '-' }}</td>
                                <td>{{ $pendose->hasil_pengukuran ?? '-' }}</td>
                                <td>{{ $pendose->tanggal_pengukuran ? $pendose->tanggal_pengukuran->format('d/m/Y') : '-' }}</td>
                                <td>{{ $pendose->kartu_dosis ? 'Ada' : 'Tidak Ada' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endforeach
        @else
            <div class="no-data">Belum ada data pemantauan Pendose untuk SDM proyek ini</div>
        @endif
    </div>

    <div class="footer">
        <p>Laporan ini dibuat secara otomatis oleh sistem SIPEMDORA</p>
        <p>Dicetak pada: {{ date('d/m/Y H:i:s') }}</p>
    </div>
</body>
</html>

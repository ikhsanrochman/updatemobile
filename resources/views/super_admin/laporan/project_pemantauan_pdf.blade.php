<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Pemantauan - {{ $project->nama_proyek }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        h2 { margin-bottom: 4px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 16px; }
        th, td { border: 1px solid #000; padding: 6px; }
        th { background: #eee; }
    </style>
    </head>
<body>
    <h2>Pemantauan Dosis - {{ $project->nama_proyek }}</h2>
    <p>Tanggal cetak: {{ date('Y-m-d H:i') }}</p>

    <h3>TLD</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Tanggal Pemantauan</th>
                <th>Dosis</th>
            </tr>
        </thead>
        <tbody>
            @php $i=1; @endphp
            @foreach($project->pemantauanDosisTld as $tld)
                <tr>
                    <td>{{ $i++ }}</td>
                    <td>{{ $tld->user->nama ?? '-' }}</td>
                    <td>{{ $tld->tanggal_pemantauan ? $tld->tanggal_pemantauan->format('Y-m-d') : '-' }}</td>
                    <td>{{ $tld->dosis }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Pendose</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Tanggal Pengukuran</th>
                <th>Hasil Pengukuran</th>
                <th>Jenis Alat</th>
            </tr>
        </thead>
        <tbody>
            @php $j=1; @endphp
            @foreach($project->pemantauanDosisPendose as $p)
                <tr>
                    <td>{{ $j++ }}</td>
                    <td>{{ $p->user->nama ?? '-' }}</td>
                    <td>{{ $p->tanggal_pengukuran ? $p->tanggal_pengukuran->format('Y-m-d') : '-' }}</td>
                    <td>{{ $p->hasil_pengukuran ?? '-' }}</td>
                    <td>{{ $p->jenis_alat_pemantauan ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>


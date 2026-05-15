<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Slip Gaji - {{ $data->employee->name }}</title>
    <style>
        body { 
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; 
            font-size: 14px; 
            color: #334155;
            line-height: 1.5;
        }
        .header { 
            text-align: center; 
            border-bottom: 2px solid #e2e8f0; 
            padding-bottom: 20px; 
            margin-bottom: 30px;
        }
        .title { 
            font-size: 24px; 
            font-weight: 800; 
            color: #1e293b;
            letter-spacing: -0.5px;
        }
        .subtitle {
            font-size: 16px;
            font-weight: 600;
            color: #64748b;
            margin-top: 5px;
        }
        .period {
            display: inline-block;
            background-color: #f1f5f9;
            color: #475569;
            padding: 4px 12px;
            border-radius: 4px;
            font-size: 13px;
            font-weight: bold;
            margin-top: 10px;
        }
        .info-table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-bottom: 30px;
        }
        .info-table td { 
            padding: 6px 0; 
        }
        .info-table td strong {
            color: #475569;
        }
        .rincian-table { 
            width: 100%; 
            border-collapse: collapse; 
        }
        .rincian-table th {
            background-color: #2563eb;
            color: #ffffff;
            padding: 12px;
            font-weight: 600;
            text-align: left;
            border: 1px solid #2563eb;
        }
        .rincian-table td { 
            padding: 12px; 
            border: 1px solid #e2e8f0;
        }
        .jumlah { 
            text-align: right; 
            font-weight: bold; 
            color: #1e293b;
        }
        .total-area td { 
            background-color: #f8fafc; 
            padding: 16px 12px;
            border-top: 2px solid #cbd5e1;
        }
        .total-area strong {
            color: #2563eb;
            font-size: 16px;
        }
        .total-nominal {
            margin: 0;
            color: #2563eb;
            font-size: 20px;
        }
        .signature-area {
            text-align: right; 
            margin-top: 60px;
            color: #475569;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">Sistem Manajemen Gaji PT. Hisan Makmur</div>
        <div class="subtitle">SLIP GAJI KARYAWAN</div>
        <div class="period">Periode: {{ $data->month_year }}</div>
    </div>

    <table class="info-table">
        <tr>
            <td width="150"><strong>Nomor Induk (NIK)</strong></td> <td width="10">:</td> <td>{{ $data->employee->nik }}</td>
        </tr>
        <tr>
            <td><strong>Nama Lengkap</strong></td> <td>:</td> <td><strong>{{ $data->employee->name }}</strong></td>
        </tr>
        <tr>
            <td><strong>Jabatan / Posisi</strong></td> <td>:</td> <td>{{ $data->employee->position }}</td>
        </tr>
    </table>

    <table class="rincian-table">
        <tr>
            <th>Deskripsi Komponen</th>
            <th style="text-align: right; width: 200px;">Nominal (Rp)</th>
        </tr>
        <tr>
            <td>Gaji Pokok</td>
            <td class="jumlah">{{ number_format($data->basic_salary, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>Tunjangan Tambahan (Transportasi, dll)</td>
            <td class="jumlah" style="color: #059669;">+ {{ number_format($data->allowance, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>Potongan / Pajak</td>
            <td class="jumlah" style="color:#e11d48;">- {{ number_format($data->deduction, 0, ',', '.') }}</td>
        </tr>
        <tr class="total-area">
            <td><strong>TAKE HOME PAY (TOTAL)</strong></td>
            <td class="jumlah"><h3 class="total-nominal">{{ number_format($data->net_salary, 0, ',', '.') }}</h3></td>
        </tr>
    </table>

    <div class="signature-area">
        <p>Bogor, {{ date('j F Y') }}</p>
        <br><br><br><br>
        <p>(_________________)</p>
        <p style="margin-top: 5px;"><strong style="color: #1e293b;">Ketua Yayasan</strong></p>
    </div>
</body>
</html>
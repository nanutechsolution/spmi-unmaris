<!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8">
    <title>Notulensi Rapat Tinjauan Manajemen</title>
    <style>
        body {
            font-family: sans-serif;
            line-height: 1.6;
            color: #333;
            font-size: 12px;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .title {
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .meta-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .meta-table td {
            padding: 5px;
            vertical-align: top;
        }

        .section-title {
            font-weight: bold;
            text-decoration: underline;
            margin-top: 15px;
            margin-bottom: 5px;
            display: block;
        }

        .content-box {
            border: 1px solid #ccc;
            padding: 10px;
            min-height: 100px;
            margin-bottom: 10px;
        }

        .attendees-list {
            margin-left: 20px;
        }

        .footer {
            margin-top: 50px;
            width: 100%;
        }

        .signature {
            width: 40%;
            text-align: center;
            display: inline-block;
        }

        .signature-space {
            height: 60px;
        }
    </style>
</head>

<body>
    <div class="header">
        <span class="title">UNIVERSITAS STELLA MARIS SUMBA</span>



        <span>Lembaga Penjaminan Mutu (LPM)</span>



        <small>Formulir: Notulensi Rapat Tinjauan Manajemen (RTM)</small>
    </div>

    <table class="meta-table">
        <tr>
            <td width="20%">Siklus AMI</td>
            <td width="2%">:</td>
            <td><strong>{{ $record->cycle->name }}</strong></td>
        </tr>
        <tr>
            <td>Tanggal Rapat</td>
            <td>:</td>
            <td>{{ $record->meeting_date->format('d F Y') }}</td>
        </tr>
        <tr>
            <td>Tempat</td>
            <td>:</td>
            <td>{{ $record->location }}</td>
        </tr>
        <tr>
            <td>Agenda</td>
            <td>:</td>
            <td>{{ $record->agenda }}</td>
        </tr>
    </table>

    <span class="section-title">DAFTAR PESERTA HADIR:</span>
    <ol class="attendees-list">
        @foreach($record->attendees ?? [] as $attendee)
        <li>{{ $attendee }}</li>
        @endforeach
    </ol>

    <span class="section-title">NOTULENSI RAPAT:</span>
    <div class="content-box">
        {!! $record->minutes !!}
    </div>

    <span class="section-title">KESIMPULAN & REKOMENDASI STRATEGIS:</span>
    <div class="content-box" style="background-color: #f9f9f9;">
        {!! $record->conclusions !!}
    </div>

    <div class="footer">
        <div class="signature" style="float: left;">
            Mengetahui,<br>
            Ketua LPM
            <div class="signature-space"></div>
            (........................................)
        </div>
        <div class="signature" style="float: right;">
            Sumba, {{ date('d M Y') }}<br>
            Sekretaris Rapat
            <div class="signature-space"></div>
            (........................................)
        </div>
        <div style="clear: both;"></div>
    </div>


</body>

</html>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>{{ $letter->letter_number }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11pt;
            line-height: 1.6;
            color: #111
        }

        .page {
            width: 100%;
            margin: 0 auto
        }

        .kop {
            border-bottom: 3px double #111;
            padding-bottom: 10px;
            margin-bottom: 24px;
            text-align: center
        }

        .kop img {
            height: 70px;
            float: left;
            object-fit: contain
        }

        .kop strong {
            font-size: 14pt;
            text-transform: uppercase
        }

        .kop span {
            display: block;
            font-size: 10pt
        }

        .meta {
            margin-bottom: 24px
        }

        .meta td {
            vertical-align: top;
            padding: 1px 8px 1px 0
        }

        .content {
            white-space: pre-line;
            text-align: justify
        }

        .signature {
            margin-top: 42px;
            margin-left: 62%;
            text-align: center
        }

        .signature-space {
            height: 70px
        }

        .print-link {
            display: block;
            margin: 18px auto;
            width: max-content;
            padding: 8px 14px;
            background: #0f766e;
            color: #fff;
            text-decoration: none;
            font: 14px Arial
        }

        @media print {
            .print-link {
                display: none
            }
        }
    </style>
</head>

<body>
    <div class="page">@if($preview)<a class="print-link" href="#" onclick="window.print();return false">Cetak surat</a>@endif @if($letter->use_letterhead && $school)<div class="kop">@if($school->school_logo_path)<img src="{{ Storage::disk('public')->url($school->school_logo_path) }}">@endif<strong>{{ $school->government_name }}</strong><span>{{ $school->department_name }}</span><strong>{{ $school->school_name }}</strong><span>{{ $school->address }}</span><span>{{ $school->email }} · {{ $school->website }}</span></div>@endif<div class="meta">
            <table>
                <tr>
                    <td>Nomor</td>
                    <td>: {{ $letter->letter_number }}</td>
                </tr>
                <tr>
                    <td>Lampiran</td>
                    <td>: {{ $letter->lampiran ?: '-' }}</td>
                </tr>
                <tr>
                    <td>Perihal</td>
                    <td>: <strong>{{ $letter->subject }}</strong></td>
                </tr>
            </table>
        </div>
        <p>Yth. {{ $letter->recipient }}<br>{{ $letter->recipient_position }}<br>{{ $letter->recipient_address }}</p>
        <p>{{ $letter->opening }}</p>
        <div class="content">{!! $letter->body !!}</div>
        <p class="content">{{ $letter->closing }}</p>
        <div class="signature">{{ $school?->school_name }}<br>{{ $letter->signer_position }}
            <div class="signature-space"></div><strong><u>{{ $letter->signer_name }}</u></strong><br>NIP. {{ $letter->signer_nip ?: '-' }}
        </div>
    </div>
</body>

</html>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rapport journalier - {{ $rapport->date }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
            border: 1px solid #ccc;
            background-color: #fff;
        }
        .header {
            display: flex;
            justify-content: space-between;
            border-bottom: 3px solid #025239;
            padding-bottom: 15px;
            margin-bottom: 25px;
            align-items: center;
        }
        .logo img {
            max-height: 80px;
        }
        .company-info {
            line-height: 1.3;
        }
        .company-info .name {
            font-weight: bold;
            font-size: 22px;
            color: #025239;
        }
        .report-title {
            font-size: 26px;
            font-weight: bold;
            color: #025239;
        }
        .report-date {
            font-size: 14px;
            color: #666;
        }
        .section {
            margin-bottom: 30px;
        }
        .section-title {
            font-size: 18px;
            font-weight: bold;
            color: #025239;
            border-bottom: 2px solid #ddd;
            padding-bottom: 6px;
            margin-bottom: 15px;
        }
        .summary {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 6px;
            font-size: 16px;
            line-height: 1.5;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 15px;
        }
        table th, table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        table th {
            background-color: #025239;
            color: white;
        }
        table tfoot td {
            font-weight: bold;
            background-color: #f0f0f0;
        }
        .footer {
            margin-top: 40px;
            border-top: 1px solid #ddd;
            padding-top: 15px;
            font-size: 13px;
            color: #666;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">
            <img src="{{ public_path('logoAuth.png') }}" alt="Logo Authantik">
        </div>
        <div class="company-info">
            <div class="name">AUTHANTIK</div>
            <div>Dixinn Terasse, Conakry</div>
            <div>Tél: 620.18.58.93</div>
            <div>Email: authantik@gmail.com</div>
        </div>
        <div class="report-info">
            <div class="report-title">Rapport Journalier</div>
            <div class="report-date">Date: {{ \Carbon\Carbon::parse($rapport->date)->format('d/m/Y') }}</div>
        </div>
    </div>

    <div class="section">
        <h2 class="section-title">Résumé du Jour</h2>
        <div class="summary">
            <p>Voici le rapport des activités du <strong>{{ \Carbon\Carbon::parse($rapport->date)->format('d/m/Y') }}</strong> pour AUTHANTIK.</p>
            <p><strong>Total des ventes:</strong> {{ number_format($rapport->total_ventes, 0, ',', ' ') }} F</p>
            <p><strong>Total des dépenses:</strong> {{ number_format($rapport->total_depenses, 0, ',', ' ') }} F</p>
            <p><strong>Bénéfice net:</strong> {{ number_format($rapport->benefice, 0, ',', ' ') }} F</p>
        </div>
    </div>

    <div class="section">
        <h2 class="section-title">Détails</h2>
        <table>
            <thead>
                <tr>
                    <th>Type</th>
                    <th>Montant (F)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Ventes Totales</td>
                    <td>{{ number_format($rapport->total_ventes, 0, ',', ' ') }}</td>
                </tr>
                <tr>
                    <td>Dépenses Totales</td>
                    <td>{{ number_format($rapport->total_depenses, 0, ',', ' ') }}</td>
                </tr>
                <tr>
                    <td><strong>Bénéfice</strong></td>
                    <td><strong>{{ number_format($rapport->benefice, 0, ',', ' ') }}</strong></td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="footer">
        <p>Dixinn Terasse - Conakry - Tél: 620.18.58.93 - Email: authantik@gmail.com</p>
    </div>
</body>
</html>

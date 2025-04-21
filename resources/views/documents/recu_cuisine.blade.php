<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reçu #{{ $order->id }}</title>
    <style>
        .recu_content {
                font-family: 'DejaVu Sans', sans-serif;
                margin: 0 auto;
                padding: 10px;
                font-size: 10pt;
                width: 100%; /* Largeur standard pour ticket thermique 80mm*/
                border: 1px solid #ccc;
            }
            .recu_content .text-center {
                text-align: center;
            }
            .recu_content .text-right {
                text-align: right;
            }
            .recu_content .bold {
                font-weight: bold;
            }
            .recu_content .header {
                text-align: center;
                margin-bottom: 10px;
            }
            .recu_content .logo {
                display: flex;
                justify-content: center;
                align-items: center;
                margin-bottom: 10px;
            }
            .recu_content .logo img {
                max-width: 25mm;
                height: auto;
                object-fit: cover;
            }
            .recu_content .divider {
                border-bottom: 1px dashed #000;
                margin: 8px 0;
            }
            .recu_content .order-info {
                font-size: 10pt;
                margin-bottom: 10px;
            }
            .recu_content .items {
                width: 100%;
                border-collapse: collapse;
                font-size: 9pt;
            }
            .recu_content .items td {
                padding: 3px 0;
            }
            .recu_content .item-qty {
                width: 15%;
                text-align: center;
            }
            .recu_content .item-name {
                width: 60%;
            }
            .recu_content .item-price {
                width: 25%;
                text-align: right;
            }
            .recu_content .totals {
                margin-top: 5px;
                font-size: 10pt;
            }
            .recu_content .total-row {
                display: flex;
                justify-content: space-between;
                margin: 2px 0;
            }
            .recu_content .grand-total {
                font-size: 12pt;
                font-weight: bold;
                margin-top: 5px;
            }
            .recu_content .footer {
                margin-top: 15px;
                text-align: center;
                font-size: 9pt;
            }
    </style>
</head>
<body>
    <div class="recu_content">
        <div class="header">
            <div class="logo">
                <img src="{{ public_path('logoAuth.png') }}">
            </div>
            <div class="company-info">
                <div class="bold">AUTHANTIK</div>
                <div>DIXINN TERASSE</div>
                <div>Conakry</div>
                <div>Tél: 620.18.58.93</div>
                <div class="">Email: authantik@gmail.com</div>
            </div>
        </div>
        
        <div class="divider"></div>
        
        <div class="order-info">
            <div class="text-center bold">BON DE COMMANDE #{{ $order->id }}</div>
            <div>Date: {{ $order->created_at->format('d/m/Y H:i') }}</div>
            <div>Client: {{ $order->name }}</div>
            <div>Tél: {{ $order->phone }}</div>
            @if($order->ddress)
            <div>Adresse: {{ $order->ddress }}</div>
            @endif
        </div>
        
        <div class="divider"></div>
        
        <table class="items">
            <thead>
                <tr>
                    <th class="item-qty">Qté</th>
                    <th class="item-name">Article</th>
                    <th class="item-price">Prix</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                <tr>
                    <td class="item-qty">{{ $item->quantity }}</td>
                    <td class="item-name">{{ $item->product->name }}</td>
                    <td class="item-price">{{ number_format($item->quantity * $item->price) }} F</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        <div class="divider"></div>
        
        <div class="totals">
            <div class="total-row">
                <span>TOTAL</span>
                <span class="bold">{{ number_format($order->total) }} F</span>
            </div>
        </div>
        
        <div class="divider"></div>
        
        <div class="footer">
            <div class="text-center">** COMMANDE CUISINE **</div>
            <div class="text-center">{{ date('d/m/Y H:i:s') }}</div>
            <div class="text-center">PRÉPARATION</div>
        </div>

    </div>
</body>
</html>
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
                text-align: center;
            }
            .recu_content .items td {
                padding: 1px 0;
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
            .recu_content .item-name .note {
                font-size: 13px;
                color: #7e7e7f;
            }
    </style>
</head>
<body>
    <div class="recu_content">
        <div class="header">
            <div class="logo">
                @if($logo_path)
                    <img src="{{ $logo_path }}" alt="Logo" style="width: 100px;">
                @else
                    <img src="{{ public_path('logoAuth.png') }}"  alt="Logo" style="width: 100px;">
                @endif
            </div>
            <div class="company-info">
                <div class="bold">{{$settings->name ?? "AUTHANTIK"}}</div>
                <div>Conakry, Guinée</div>
            </div>
        </div>
        
        <div class="divider"></div>
        
        <div class="order-info">
            <div class="text-center bold">BON DE COMMANDE #{{ $order->id }}</div>
        </div>
        
        <div class="divider"></div>
        
        <table class="items">
            <thead>
                <tr>
                    <th class="item-qty">Qté</th>
                    <th class="item-name">Article</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                <tr>
                    <td class="item-qty">{{ $item->quantity }}</td>
                    <td class="item-name">
                        <p>{{ $item->product->name }}</p>
                    </td>
                </tr>
                @endforeach
                @if($order->note)
                <tr>
                    <td class="bold">Note : </td>
                    <td>{{$order->note}}</td>
                </tr>
                @endif
            </tbody>
        </table>

    </div>
</body>
</html>
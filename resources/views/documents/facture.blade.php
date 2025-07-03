<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Facture #{{ $order->id }}</title>
    <style>
       
        .main{
            width: 100%;
        }
        .recu_content {
                font-family: 'DejaVu Sans', sans-serif;
                margin: 0;
                padding: 10px;
                font-size: 10pt;
                width: 100%;  /*Largeur standard pour ticket thermique 80mm*/
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
            .recu_content .lieu {
                border-top: 1px dashed #000;
                padding: 2px 3px;
            }
            .recu_content .order-info {
                font-size: 10pt;
                margin-bottom: 10px;
            }
            .recu_content .order-info .title {
                font-size: 20px;
                font-weight: bold;
                text-align: center;
            }
            .recu_content .items {
                width: 100%;
                border-collapse: collapse;
                font-size: 9pt;
                text-align: center;
            }
            .recu_content .items td {
                padding: 3px 0;
            }
            .recu_content .item-name {
                width: 70%;
                text-align: left;
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
                width: 100%;
                margin: 2px 0;
                display: flex;
                justify-content: space-between;
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
    <div class="main">
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
                    <div>{{$settings->address ?? "DIXINN Terasse"}}</div>
                    <div>Tél: {{$settings->phone ?? "620.18.58.93"}} </div>
                    <div class="">Email: {{$settings->email ?? "authantik@gmail.com"}} </div>
                </div>
            </div>
            
            <div class="divider"></div>
            
            <div class="order-info">
                <div class="title">Commande {{ $order->id }}</div>
                <div>{{ $order->employee_id ? 'Employé(e) : '. $order->employee->name : '' }}</div>
                <div class="lieu">
                    <p>{{ $order->lieu }}</p>
                    @if($order->address)
                    <p>Adresse: {{ $order->address->quartier }}</p>
                    @endif
                </div>
            </div>
            
            <div class="divider"></div>
            
            <table class="items">
                <thead>
                    <tr>
                        <!-- <th class="item-qty">Qté</th> -->
                        <th class="item-name">Article</th>
                        <th class="item-price">Prix</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $item)
                    <tr>
                        <!-- <td class="item-qty">{{ $item->quantity }}</td> -->
                        <td class="item-name">
                            <p>{{ $item->product->name }}</p>
                            <p>{{ $item->quantity }} * {{ str_replace(',','.',number_format($item->price, 0, '.')) }}</p>
                            @if($item->note)
                            <p>{{ $item->note }}</p>
                            @endif
                        </td>
                        <td class="item-price">{{ str_replace(',','.',number_format($item->quantity * $item->price, 0, '.')) }} F</td>
                    </tr>
                    <tr>
                        <td class="divider" colspan="2"></td>
                    </tr>
                    @endforeach
                    <tr>
                        <td class="item-name">TOTAL</td>
                        <td class="bold item-price">{{ str_replace(',', '.',$order->total) }} F</td>
                    </tr>
                </tbody>
            </table>
            
            
            <div class="divider"></div>
            
            <div class="footer">
                <div class="text-center">** Merci pour la confiance **</div>
                <div class="text-center">{{ date('d/m/Y H:i:s') }}</div>
            </div>
    
        </div>
    </div>
</body>
</html>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Facture #{{ $order->nocmd }}</title>
    <style>
        .facture_container { 
            font-family: DejaVu Sans, sans-serif; 
            margin: 0;
            padding: 20px;
            color: #333;
            max-width: 800px;
            margin: 0 auto;
            border: 1px solid #ccc;
        }
        .facture_container .header {
            padding-bottom: 20px;
            border-bottom: 2px solid #025239;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        /* .facture_container .header-left {
            flex: 1;
        } */
        .facture_container .header-right {
            text-align: right;
        }
        .facture_container .logo img {
            max-height: 80px;
            margin-bottom: 10px;
        }
        .facture_container .invoice-title {
            font-size: 28px;
            color: #025239;
            margin: 0;
        }
        .facture_container .invoice-details {
            color: #666;
            font-size: 14px;
        }
        .facture_container .section {
            margin: 30px 0;
        }
        .facture_container .section-title {
            color: #025239;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
            margin-bottom: 15px;
        }
        .facture_container .client-info, .payment-info {
            padding: 15px;
            background-color: #f9f9f9;
            border-radius: 5px;
        }
        .facture_container .table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        .facture_container .table th {
            background-color: #025239;
            color: white;
            padding: 10px;
            text-align: left;
        }
        .facture_container .table td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }
        .facture_container .table tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .facture_container .subtotal-row td {
            border-top: 1px solid #ddd;
        }
        .facture_container .total-row td {
            font-weight: bold;
            font-size: 16px;
            border-top: 2px solid #025239;
            background-color: #f9f9f9;
        }
        .facture_container .text-right {
            text-align: right;
        }
        .facture_container .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
        .facture_container .payment-terms {
            margin-top: 30px;
            padding: 15px;
            background-color: #f9f9f9;
            border-left: 4px solid #025239;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="facture_container">
        <div class="header">
            <div class="header-left">
                <div class="logo">
                    <img src="{{ public_path('logoAuth.png') }}" loading="lazy">
                </div>
                <div class="company-info">
                <div class="bold">AUTHANTIK</div>
                <div>DIXINN TERASSE</div>
                <div>Conakry</div>
                <div>Tél: 620.18.58.93</div>
                <div class="">Email: authantik@gmail.com</div>
                </div>
            </div>
            <div class="header-right">
                <h1 class="invoice-title">FACTURE</h1>
                <div class="invoice-details">
                    <p><strong>Facture N°:</strong> {{ $order->id }}<br>
                    <strong>Date:</strong> {{ $order->created_at->format('d/m/Y') }}<br>
                    <strong>Référence:</strong> {{ $order->NoCMDParAn }}<br>
                    <strong>Échéance:</strong> {{ $order->created_at->addDays(30)->format('d/m/Y') }}</p>
                </div>
            </div>
        </div>

        <div class="section">
            <div class="client-info">
                <h3 class="section-title">INFORMATIONS CLIENT</h3>
                <p><strong>{{ $order->name }}</strong><br>
                {{ $order->address->name }}<br>
                Tél: {{ $order->phone }}</p>
            </div>
        </div>

        <div class="section">
            <h3 class="section-title">DÉTAIL DE LA COMMANDE</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th width="40%">Description</th>
                        <th width="15%">Quantité</th>
                        <th width="20%">Prix unitaire</th>
                        <th width="25%">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $item)
                    <tr>
                        <td>{{ $item->product->name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td class="text-right">{{ number_format($item->price) }} F</td>
                        <td class="text-right">{{ number_format($item->quantity * $item->price) }} F</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="total-row">
                        <td colspan="3" class="text-right">TOTAL</td>
                        <td class="text-right">{{ number_format($order->total) }} F</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="payment-terms">
            <h4>Conditions de paiement</h4>
            <p>Paiement exigible dans les 30 jours suivant la date de facturation. Veuillez effectuer votre paiement sur l'un de nos contacts :</p>
            <p><strong>Orange Money:</strong> 620185893<br>
            <strong>MOBILE MONEY:</strong> 664568765<br></p>
        </div>

        <div class="footer">
            <p>AUTHANTIK - Dixinn Terasse - 620185893<br>
            Merci pour votre confiance!</p>
        </div>
    </div>
</body>
</html>
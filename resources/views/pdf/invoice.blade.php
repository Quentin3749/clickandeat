{{--
    Vue de génération de facture PDF
    - Sert à générer une facture téléchargeable ou imprimable pour une commande
    - Utilise une mise en page simple et adaptée à l'impression PDF
    - Explique chaque section (entête, infos client, détails commande, total)
--}}
<!DOCTYPE html>
<html lang="fr">
<head>
    {{-- Métadonnées et styles pour le PDF --}}
    <meta charset="UTF-8">
    <title>Facture Commande #{{ $order->id }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 14px; }
        .header { text-align: center; margin-bottom: 30px; }
        .infos { margin-bottom: 20px; }
        .total { font-size: 18px; font-weight: bold; margin-top: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #ccc; padding: 8px; }
        th { background: #f5f5f5; }
    </style>
</head>
<body>
    <div class="header"> {{-- Entête de la facture --}}
        <h2>Facture</h2>
        <p>Commande n°{{ $order->id }}</p>
    </div>
    <div class="infos"> {{-- Infos client --}}
        <strong>Date :</strong> {{ $order->created_at->format('d/m/Y H:i') }}<br>
        <strong>Client :</strong> {{ $order->user->name }}<br>
        <strong>Restaurant :</strong> {{ $order->restaurant->name ?? '-' }}
    </div>
    <table>
        <thead>
            <tr>
                <th>Produit</th>
                <th>Quantité</th>
                <th>Prix unitaire (€)</th>
                <th>Total (€)</th>
            </tr>
        </thead>
        <tbody>
        @foreach($order->items as $item)
            <tr>
                <td>{{ $item->name }}</td>
                <td>{{ $item->pivot->quantity }}</td>
                <td>{{ number_format($item->price, 2, ',', ' ') }}</td>
                <td>{{ number_format($item->price * $item->pivot->quantity, 2, ',', ' ') }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="total"> {{-- Total de la facture --}}
        Montant total : {{ number_format($order->total_amount, 2, ',', ' ') }} €
    </div>
</body>
</html>

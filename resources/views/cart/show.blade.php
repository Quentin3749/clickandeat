@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Mon panier</h2>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @if(empty($cart))
        <div class="alert alert-info">Votre panier est vide.</div>
    @else
        <table class="table table-bordered align-middle">
            <thead>
                <tr>
                    <th>Plat</th>
                    <th>Quantité</th>
                    <th>Prix unitaire</th>
                    <th>Sous-total</th>
                    {{-- <th></th> --}}
                </tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @foreach($cart as $itemId => $qty)
                    @php
                        $item = \App\Models\Item::find($itemId);
                        if($item) $total += $item->price * $qty;
                    @endphp
                    @if($item)
                    <tr>
                        <td>{{ $item->name }}</td>
                        <td>{{ $qty }}</td>
                        <td>{{ number_format($item->price, 2) }} €</td>
                        <td>{{ number_format($item->price * $qty, 2) }} €</td>
                        {{-- <td>
                            <form method="POST" action="{{ route('cart.remove', $item->id) }}">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm">Retirer</button>
                            </form>
                        </td> --}}
                    </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <strong>Total&nbsp;: {{ number_format($total, 2) }} €</strong>
            </div>
            <form method="POST" action="{{ route('cart.checkout', optional($item)->restaurant_id ?? 0) }}">
                @csrf
                <button type="submit" class="btn btn-success">Payer ma commande</button>
            </form>
        </div>
    @endif
</div>
@endsection

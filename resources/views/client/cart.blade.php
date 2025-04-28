@extends('layouts.app')

@section('content')
<div class="dashboard-container" style="min-height:90vh;display:flex;flex-direction:column;justify-content:center;align-items:center;background:linear-gradient(120deg,#e0e7ff 0%,#f1f5f9 100%);">
    <div class="dashboard-card animate__animated animate__fadeInDown" style="background:#fff;border-radius:2rem;box-shadow:0 8px 40px rgba(44,62,80,0.10);padding:2.5rem 2rem 2rem 2rem;margin-bottom:2rem;width:100%;max-width:650px;">
        <h2 class="dashboard-title mb-4 text-center" style="font-family:'Poppins',sans-serif;color:#2563eb;font-weight:800;letter-spacing:1px;text-shadow:1px 1px 0 #e0e7ff;">
            <i class="fa fa-shopping-cart me-2"></i>Mon Panier
        </h2>
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        @php $cart = session('cart', []); @endphp
        @if(empty($cart))
            <p class="text-muted text-center">Votre panier est vide.</p>
        @else
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr style="background:#f1f5f9;">
                            <th>Plat</th>
                            <th>Prix</th>
                            <th>Quantité</th>
                            <th>Total</th>
                            <th>Action</th>
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
                        <tr style="background:#fff;">
                            <td><b>{{ $item->name }}</b></td>
                            <td>{{ number_format($item->price, 2, ',', ' ') }} €</td>
                            <td>{{ $qty }}</td>
                            <td>{{ number_format($item->price * $qty, 2, ',', ' ') }} €</td>
                            <td>
                                <form method="POST" action="{{ route('cart.remove', $item->id) }}" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm">Retirer</button>
                                </form>
                            </td>
                        </tr>
                        @endif
                    @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="3" class="text-end">Total</th>
                            <th colspan="2">{{ number_format($total, 2, ',', ' ') }} €</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <form method="POST" action="{{ route('stripe.checkout') }}" class="text-center mt-3">
                @csrf
                <button type="submit" style="background:#2563eb;color:#fff;border:none;border-radius:0.5rem;min-width:180px;font-size:1.15rem;font-weight:700;letter-spacing:1px;padding:0.7rem 2.2rem;box-shadow:0 4px 16px rgba(44,62,80,0.10);transition:background 0.2s;" onmouseover="this.style.background='#1d4ed8'" onmouseout="this.style.background='#2563eb'">
                    <i class="fa fa-credit-card me-2"></i>Payer
                </button>
            </form>
        @endif
        <div class="text-center mt-4">
            <a href="{{ route('client.dashboard') }}" class="btn btn-outline-secondary px-4">Retour espace client</a>
        </div>
    </div>
</div>
@endsection

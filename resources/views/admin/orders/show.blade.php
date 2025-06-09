@extends('layouts.app')
@section('content')
<div class="container py-4">
    <h2>Détail commande #{{ $order->id }}</h2>
    <ul>
        <li><strong>Client :</strong> {{ $order->user->name ?? '-' }}</li>
        <li><strong>Restaurant :</strong> {{ $order->restaurant->name ?? '-' }}</li>
        <li><strong>Total :</strong> {{ $order->total }}</li>
        <li><strong>Status :</strong> {{ $order->status }}</li>
        <li><strong>Date :</strong> {{ $order->created_at }}</li>
    </ul>
    <a href="{{ route('admin.orders.edit', $order) }}" class="btn btn-warning">Modifier</a>
    <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Retour</a>
</div>
@endsection

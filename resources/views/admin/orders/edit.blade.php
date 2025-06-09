@extends('layouts.app')
@section('content')
<div class="container py-4">
    <h2>Modifier la commande #{{ $order->id }}</h2>
    <form action="{{ route('admin.orders.update', $order) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>Status</label>
            <input type="text" name="status" class="form-control" value="{{ $order->status }}" required>
        </div>
        <button type="submit" class="btn btn-warning">Modifier</button>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Retour</a>
    </form>
</div>
@endsection

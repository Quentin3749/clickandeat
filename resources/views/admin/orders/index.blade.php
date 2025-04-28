@extends('layouts.app')
@section('content')
<div class="container py-4">
    <h2>Commandes</h2>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Client</th>
                <th>Restaurant</th>
                <th>Total</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>{{ $order->id }}</td>
                <td>{{ $order->user->name ?? '-' }}</td>
                <td>{{ $order->restaurant->name ?? '-' }}</td>
                <td>{{ $order->total }}</td>
                <td>{{ $order->status }}</td>
                <td>
                    <a href="{{ route('admin.orders.edit', $order) }}" class="btn btn-sm btn-warning">Modifier</a>
                    <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Supprimer cette commande ?')">Supprimer</button>
                    </form>
                    <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-info">Voir</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $orders->links() }}
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="dashboard-container" style="min-height:90vh;display:flex;flex-direction:column;justify-content:center;align-items:center;background:linear-gradient(120deg,#e0e7ff 0%,#f1f5f9 100%);">
    <div class="dashboard-card animate__animated animate__fadeInDown" style="background:#fff;border-radius:2rem;box-shadow:0 8px 40px rgba(44,62,80,0.10);padding:2.5rem 2rem 2rem 2rem;margin-bottom:2rem;width:100%;max-width:650px;">
        <h2 class="dashboard-title mb-4 text-center" style="font-family:'Poppins',sans-serif;color:#2563eb;font-weight:800;letter-spacing:1px;text-shadow:1px 1px 0 #e0e7ff;">
            <i class="fa fa-check-circle me-2 text-success"></i>Paiement validé !
        </h2>
        <p class="text-center fs-5 mb-4">Merci pour votre commande.<br>Vous recevrez un email de confirmation sous peu.</p>
        <div class="text-center mt-4">
            <a href="{{ route('client.dashboard') }}" class="btn btn-outline-secondary px-4">Retour espace client</a>
        </div>
    </div>
</div>
@endsection

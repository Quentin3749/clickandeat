@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Créer une Nouvelle Commande</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('orders.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="restaurant_id" class="form-label">Restaurant</label>
                <select class="form-control" id="restaurant_id" name="restaurant_id" required>
                    <option value="">Sélectionnez un restaurant</option>
                    @foreach($restaurants as $restaurant)
                        <option value="{{ $restaurant->id }}">{{ $restaurant->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="reservation_time" class="form-label">Heure de Réservation (Optionnel)</label>
                <input type="datetime-local" class="form-control" id="reservation_time" name="reservation_time">
                <small class="form-text text-muted">Laissez vide si la commande est immédiate.</small>
            </div>

            <div class="mb-3">
                <label for="notes" class="form-label">Notes Spéciales (Optionnel)</label>
                <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
            </div>

            <div id="restaurant-items" class="mt-4">
                </div>

            <button type="submit" class="btn btn-primary">Créer la Commande</button>
            <a href="{{ route('orders.index') }}" class="btn btn-secondary">Annuler</a>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const restaurantSelect = document.getElementById('restaurant_id');
            const itemsContainer = document.getElementById('restaurant-items');

            restaurantSelect.addEventListener('change', function () {
                const restaurantId = this.value;
                if (restaurantId) {
                    fetch(`/restaurants/${restaurantId}/items`)
                        .then(response => response.json())
                        .then(data => {
                            itemsContainer.innerHTML = ''; // Effacer les articles précédents
                            if (data.length > 0) {
                                const itemsTitle = document.createElement('h3');
                                itemsTitle.textContent = 'Sélectionnez les Articles :';
                                itemsContainer.appendChild(itemsTitle);

                                data.forEach(item => {
                                    const itemDiv = document.createElement('div');
                                    itemDiv.classList.add('mb-2');

                                    const label = document.createElement('label');
                                    label.textContent = `${item.name} - Prix: ${item.price} €`;
                                    label.setAttribute('for', `item_${item.id}`);

                                    const input = document.createElement('input');
                                    input.type = 'number';
                                    input.classList.add('form-control', 'form-control-sm');
                                    input.id = `item_${item.id}`;
                                    input.name = `items[${item.id}]`;
                                    input.value = 0; // Initialiser la quantité à 0
                                    input.min = 0;

                                    itemDiv.appendChild(label);
                                    itemDiv.appendChild(input);
                                    itemsContainer.appendChild(itemDiv);
                                });
                            } else {
                                itemsContainer.innerHTML = '<p>Ce restaurant n\'a pas d\'articles disponibles pour le moment.</p>';
                            }
                        });
                } else {
                    itemsContainer.innerHTML = ''; // Effacer les articles si aucun restaurant n'est sélectionné
                }
            });
        });
    </script>
@endsection
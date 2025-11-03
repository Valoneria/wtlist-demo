<!-- resources/views/components/vehicle/vehicle-card.blade.php -->
<a class="border dark:border-gray-700 p-4 dark:shadow-white shadow-sm hover:shadow-md transition-shadow" href="https://wiki.warthunder.com/unit/{{ $vehicle->api_identifier  }}" target="_blank">
    <h3 class="text-xl font-semibold mb-2 flex ">
        <img
            src="{{ Storage::url('vehicle_types/' . $vehicle->type->slug . '.svg') }}"
            alt="{{ $vehicle->type->name }}"
            class="w-10 h-auto mr-4"
        >
        {{ $vehicle->name }}
        @if($vehicle->is_premium == 1)
            <img
                src="{{ Storage::url('icons/item_type_talisman.svg') }}"
                alt="{{ $vehicle->type->name }} is a premium"
                class="w-5 h-auto ml-4"
            >
        @endif
    </h3>
    <div class="py-2 grid grid-cols-3">
        <span>
            <strong>Rank:</strong> {{ $vehicle->rank }}</p>
        </span>
        <span>
            <strong>BR (AB):</strong> {{ $vehicle->arcade_battle_rating }}
        </span>
        <span>
            <strong>BR (RB):</strong> {{ $vehicle->realistic_battle_rating }}
        </span>

    </div>
    <img
        src="{{ asset($vehicle->image_path) }}"
        alt="{{ $vehicle->name }}"
        class="w-full h-48 object-cover mb-4"
    >
    <div class="space-y-2">
        <p><strong>Type:</strong> {{ $vehicle->type->name ?? 'Unknown' }}</p>
        <p><strong>Price (SL):</strong>  {{ $vehicle->sl_price ?? '0' }}</p>
        <p><strong>Price (GE):</strong>  {{ $vehicle->ge_price ?? '0' }}</p>
        <p><strong>Research points (RP):</strong>  {{ $vehicle->is_premium == 0 ? $vehicle->research_points_requirement :  '0' }}</p>
    </div>
</a>

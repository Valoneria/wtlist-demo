@props(['country', 'vehicles' => null])
@php
    $ranks = [
        1 => 'I',
        2 => 'II',
        3 => 'III',
        4 => 'IV',
        5 => 'V',
        6 => 'VI',
        7 => 'VII',
        8 => 'VIII',
        9 => 'IX',
        10 => 'X'
    ]
@endphp
<div class="overflow-hidden shadow-sm">
    <!-- Country header (clickable) -->
    <button
        class="w-full p-4 text-left bg-gray-50 hover:bg-gray-100 dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700 flex items-center justify-between"
        onclick="toggleAccordion('country-{{ $country->id }}')"
    >
        <div class="flex items-center">
            <img
                src="{{ Storage::url('flags/country_' . $country->slug . '.svg') }}"
                alt="{{ $country->name }}"
                class="w-10 h-auto mr-4"
            >
            <span class="text-lg font-semibold dark:text-gray-200">
                {{ $country->name }}
                <small>
                    ({{ $vehicles ? $vehicles->count() : $country->vehicles->count() }})
                </small>
            </span>
        </div>
        <svg
            id="chevron-country-{{ $country->id }}"
            class="w-6 h-6 transition-transform duration-200"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg"
        >
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
        </svg>
    </button>
    <!-- Vehicles (Collapsible) -->
    <div
        id="country-{{ $country->id }}"
        class="hidden"
    >
        <div class="p-4 bg-white dark:bg-gray-800 dark:text-gray-200">
            @php
                // Use the passed $vehicles prop (filtered vehicles)
                $filteredVehicles = $vehicles ?? $country->vehicles;
                $groupedVehicles = $filteredVehicles->groupBy('rank');
            @endphp
            @foreach($groupedVehicles as $rank => $vehicles)
                <div class="mb-6">
                    <h3 class="text-xl font-semibold mb-3">{{__('Rank') }} {{ $ranks[$rank] }}</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        @foreach($vehicles as $vehicle)
                            <x-vehicle.vehicle-card :vehicle="$vehicle" />
                        @endforeach
                    </div>
                </div>
            @endforeach
            @if($filteredVehicles->count() <= 0)
                <div class="mb-6">
                    <h3 class="text-xl font-semibold mb-3">{{ __('No vehicles for this nation') }}</h3>
                </div>
            @endif
        </div>
    </div>
</div>
<script>
    function toggleAccordion(id) {
        const element = document.getElementById(id);
        const chevron = document.getElementById(`chevron-${id}`);
        if (element.classList.contains('hidden')) {
            element.classList.remove('hidden');
            chevron.classList.add('rotate-180');
        } else {
            element.classList.add('hidden');
            chevron.classList.remove('rotate-180');
        }
    }
</script>

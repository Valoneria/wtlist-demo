@php use App\Models\VehicleCountry; @endphp

<x-app-layout>
    <x-vehicle.sort-bar :types="$types" :countries="$countries"></x-vehicle.sort-bar>
    <h1 class="text-3xl font-bold mb-6  dark:text-gray-200">{{ __('Vehicles') }}</h1>

    <div class="space-y-4">
        <div class="space-y-4">
            @foreach($groupedVehicles as $countryId => $countryVehicles)
                @php
                    $country = VehicleCountry::find($countryId);
                @endphp
                @if($country)
                    <x-vehicle.country-card :country="$country" :vehicles="$countryVehicles"/>
                @endif
            @endforeach
        </div>
    </div>
</x-app-layout>

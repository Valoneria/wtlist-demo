<form method="GET" action="{{ route('vehicle.index') }}" class="p-4 bg-white dark:bg-gray-800 dark:text-gray-200 mb-4">
    <div class="mb-6">
        <h3 class="text-xl font-semibold mb-3">{{ __('Filter by') }}</h3>
        <h4>{{ __('Vehicle type') }}</h4>
        <div class="flex gap-4 align-middle items-center">
            <x-vehicle.vehicle-type-sort-bar-radio vehicle-type-name="Light tank" vehicle-type="light_tank" :vehicle-type-id="2" />
            <x-vehicle.vehicle-type-sort-bar-radio vehicle-type-name="Medium tank" vehicle-type="medium_tank" :vehicle-type-id="3" />
            <x-vehicle.vehicle-type-sort-bar-radio vehicle-type-name="Heavy tank" vehicle-type="heavy_tank" :vehicle-type-id="4" />
            <x-vehicle.vehicle-type-sort-bar-radio vehicle-type-name="Tank destroyer" vehicle-type="tank_destroyer" :vehicle-type-id="5" />
            <x-vehicle.vehicle-type-sort-bar-radio vehicle-type-name="SPAA" vehicle-type="spaa" :vehicle-type-id="6" />
        </div>
    </div>
<!-- Filter Form -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <!-- Country Filter -->
        <div>
            <label for="country" class="block text-sm font-medium text-gray-700 dark:text-gray-200">{{__('Country')}}</label>
            <select
                name="country"
                id="country"
                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md dark:bg-gray-700"
            >
                <option value="">{{ __('All Countries') }}</option>
                @foreach($countries as $country)
                    <option value="{{ $country->id }}" {{ request('country') == $country->id ? 'selected' : '' }}>
                        {{ $country->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Min Rank Filter -->
        <div>
            <label for="min_rank" class="block text-sm font-medium text-gray-700 dark:text-gray-200">{{__('Min Rank')}}</label>
            <input
                type="number"
                name="min_rank"
                id="min_rank"
                value="{{ request('min_rank') }}"
                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md dark:bg-gray-700"
                placeholder="Min"
            >
        </div>

        <!-- Max Rank Filter -->
        <div>
            <label for="max_rank" class="block text-sm font-medium text-gray-700 dark:text-gray-200">{{__('Max Rank')}}</label>
            <input
                type="number"
                name="max_rank"
                id="max_rank"
                value="{{ request('max_rank') }}"
                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md dark:bg-gray-700"
                placeholder="Max"
            >
        </div>
    </div>

    <div class="mt-4 flex justify-end">
        <button
            type="submit"
            class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600"
        >
            {{ __('Filter') }}
        </button>
        <a
            href="{{ route('vehicle.index') }}"
            class="ml-2 px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400"
        >
            {{ __('Reset') }}
        </a>
    </div>
</form>

@props([
    'vehicleTypeId',  // CamelCase in PHP, kebab-case in HTML
    'vehicleType',
    'vehicleTypeName' => "tank"
])

<label class="block cursor-pointer">
    <input
        type="radio"
        name="vehicle_type"
        value="{{ $vehicleTypeId }}"
        class="hidden"
        {{ request('vehicle_type') == $vehicleTypeId ? 'checked' : '' }}
    >
    <div class="p-4 hover:scale-110 transition-all text-center {{ request('vehicle_type') == $vehicleTypeId ? 'bg-blue-100 ring-2 ring-blue-500 rounded-lg' : '' }}">
        <img
            src="{{ Storage::url('vehicle_types/'.$vehicleType.'.svg') }}"
            alt="{{ $vehicleType }}"
            class="w-20"
        >
        <span class="text-center">
        {{ $vehicleTypeName }}
        </span>
    </div>
</label>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get all radio buttons with name="vehicle_type"
        const radioButtons = document.querySelectorAll('input[name="vehicle_type"]');


        const classList = [
            'bg-blue-100', 'ring-2', 'ring-blue-500', 'rounded-lg'
        ];

        // Add click event listener to each radio button
        radioButtons.forEach(radio => {
            radio.addEventListener('click', function() {
                const form = radio.closest('form');

                // Remove the "selected" class from all labels
                document.querySelectorAll('input[name="vehicle_type"]').forEach(r => {
                    const label = r.closest('label');
                    const div = label.querySelector('div');
                    div.classList.remove(...classList);
                });

                // Add the "selected" class to the clicked radio's label
                const label = this.closest('label');
                const div = label.querySelector('div');
                div.classList.add(...classList);

                // Submit on choice
                form.submit();
            });
        });
    });
</script>

<x-app-layout>

    <form class="p-4 bg-white dark:bg-gray-800 dark:text-gray-200 mb-4">
        <h3 class="text-xl font-semibold mb-3">
            {{ __('Import from API') }}
        </h3>

        <div class="mt-4">
            <label for="limit" class="block text-sm font-medium text-gray-700 dark:text-gray-200">{{ __('Limit') }}</label>
            <input
                type="number"
                name="limit"
                id="limit"
                value="50"
                placeholder="Limit for the process. No value will default to 50"
                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md dark:bg-gray-700"
            >
        </div>

        <div class="mt-4 flex justify-end">
            <button
                id="importFormSubmit"
                type="button"
                class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 disabled:bg-gray-300 disabled:cursor-wait"
            >
                {{ __('Import') }}
            </button>
        </div>

        <div id="response" class="hidden mt-4 p-4 bg-gray-100 dark:bg-gray-700 rounded-lg">
        </div>
    </form>


    <x-vehicle.import-history :import-history="$importHistory"/>

    <script>
        const submitButton = document.querySelector('#importFormSubmit');
        const responseBox = document.querySelector('#response');
        submitButton.addEventListener('click',async function(){
            // Clear the previous response
            responseBox.innerHTML = "";

            //show the response box
            responseBox.classList.remove('hidden');

            // Add a spinner while loading
            responseBox.innerHTML = '<div class="spinner"></div>';

            // Disable the submit button to hinder duplicate requests
            submitButton.setAttribute('disabled','disabled');

            try {
                let limit = document.querySelector('#limit').value;

                // Fetch from the import endpoint
                const response = await fetch('/vehicle/import?limit=' + limit, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                });

                // Parse the JSON response
                const data = await response.json();

                // Format the response
                let responseText = '';
                if (response.ok) {
                    responseText = `
                <div class="text-green-600 dark:text-green-400 font-semibold mb-2">Import successful!</div>
                <pre class="whitespace-pre-wrap dark:bg-gray-500">${data[0]}</pre>
            `;
                } else {
                    responseText = `
                <div class="text-red-600 dark:text-red-400 font-semibold mb-2">Import failed!</div>
                <pre class="whitespace-pre-wrap dark:bg-gray-500">${data[0]}</pre>
            `;
                }

                // Update the response box
                responseBox.innerHTML = responseText;

            } catch (error) {
                // Handle fetch errors
                responseBox.innerHTML = `
            <div class="text-red-600 dark:text-red-400 font-semibold mb-2">An error occurred:</div>
            <pre class="whitespace-pre-wrap dark:bg-gray-500">${error.message}</pre>
        `;
            } finally {
                // Re-enable the button
                submitButton.removeAttribute('disabled');
            }


        });

    </script>

</x-app-layout>

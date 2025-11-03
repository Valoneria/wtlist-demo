<div class="bg-white p-4 mt-4 dark:bg-gray-700 dark:text-gray-200 ">
    <h3 class="text-xl font-semibold mb-3">
        {{ __('Import history') }}
    </h3>
    <table class="table-auto w-full dark:bg-gray-600">
        <thead>
        <tr>
            <th>{{ __('Status') }}</th>
            <th>{{ __('Time ran') }}</th>
            <th>{{ __('Imported') }}</th>
            <th>{{ __('Updated') }}</th>
            <th>{{ __('Skipped') }}</th>
            <th>{{ __('Failed') }}</th>
        </tr>
        </thead>
        <tbody class="text-center">
        @foreach($importHistory as $history)
            <tr class="import-{{$history->status}}">
                <td>{{$history->status}}</td>
                <td>{{$history->created_at->format('d.m.Y') }}<br/>{{$history->created_at->format('H:i') }}</td>
                <td>{{$history->imported}}</td>
                <td>{{$history->updated}}</td>
                <td>{{$history->failed}}</td>
                <td>{{$history->skipped}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

<x-filament::page>
    <div>
        <x-filament::button wire:click="createRoom">Create Room</x-filament::button>

        <table class="min-w-full mt-4">
            <thead>
            <tr>
                <th class="px-4 py-2">Room Name</th>
                <th class="px-4 py-2">URL</th>
                <th class="px-4 py-2">Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($rooms['data'] ?? [] as $room)
                <tr>
                    <td class="border px-4 py-2">{{ $room['name'] }}</td>
                    <td class="border px-4 py-2">
                        <a href="{{ $room['url'] }}" target="_blank" class="text-blue-500 underline">Join</a>
                    </td>
                    <td class="border px-4 py-2">
                        <x-filament::button color="danger" wire:click="deleteRoom('{{ $room['name'] }}')">Delete</x-filament::button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</x-filament::page>

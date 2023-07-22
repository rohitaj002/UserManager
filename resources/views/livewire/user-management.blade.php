<div>
    {{-- If your happiness depends on money, you will never be happy with yourself. --}}
</div>

<x-slot name="head">
    <x-table.heading sortable wire:click="sortBy('first_name')"
        :direction="$sortField === 'first_name' ? $sortDirection : null">{{__('Name')}}
    </x-table.heading>
    <x-table.heading sortable wire:click="sortBy('role_id')"
        :direction="$sortField === 'role_id' ? $sortDirection : null">{{__('Role')}}
    </x-table.heading>
    <x-table.heading sortable wire:click="sortBy('created_at')"
        :direction="$sortField === 'created_at' ? $sortDirection : null">{{__('Date created')}}
    </x-table.heading>
    <x-table.heading sortable wire:click="sortBy('status')"
        :direction="$sortField === 'status' ? $sortDirection : null">{{__('Status')}}
    </x-table.heading>
    @can('manage-users', auth()->user())
    <x-table.heading>{{__('Action')}}</x-table.heading>
    @endcan
</x-slot>


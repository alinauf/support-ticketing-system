<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Ticket: '. $ticket->title ) }}
        </h2>
    </x-slot>

    <livewire:ticket.detail :ticket="$ticket" />

</x-app-layout>

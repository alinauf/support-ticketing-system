<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div>


        <div class="max-w-7xl mx-auto my-12 px-4 sm:px-6 lg:px-8">


            <livewire:admin.ticket.index/>
        </div>


>
    </div>

</x-app-layout>

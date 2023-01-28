<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Support Tickets') }}
        </h2>
    </x-slot>


    <div class="max-w-7xl mx-auto my-12 px-4 sm:px-6 lg:px-8">
        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
                <h1 class="text-xl font-semibold text-gray-900">Support Tickets</h1>
                <p class="mt-2 text-sm text-gray-700">You can view below all the support tickets created</p>
            </div>
            <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                <button type="button" class="inline-flex items-center justify-center rounded-md border border-transparent bg-teal-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 sm:w-auto">Create Ticket</button>
            </div>
        </div>
        <livewire:client.ticket.index />
    </div>


</x-app-layout>

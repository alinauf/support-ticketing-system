<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Support Tickets') }}
        </h2>
    </x-slot>
    <div x-data="{ showModal: false }">


        <div class="max-w-7xl mx-auto my-12 px-4 sm:px-6 lg:px-8">
            <div class="sm:flex sm:items-center">
                <div class="sm:flex-auto">
                    <h1 class="text-xl font-semibold text-gray-900">Support Tickets</h1>
                    <p class="mt-2 text-sm text-gray-700">You can view below all the support tickets created</p>
                </div>
                <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                    <button type="button"
                            x-on:click="showModal = true"
                            class="inline-flex items-center justify-center rounded-md border border-transparent bg-teal-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 sm:w-auto">
                        Create Ticket
                    </button>
                </div>
            </div>
            <livewire:client.ticket.index/>
        </div>

        {{-- Create Ticket Modal --}}
        <div class="fixed z-10 inset-0 overflow-y-auto" x-show="showModal" aria-labelledby="modal-title"
             role="dialog"
             aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"

                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"

                     aria-hidden="true"></div>

                <!-- This element is to trick the browser into centering the modal contents. -->
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"

                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"


                        class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
                    <div>


                        <div class="mt-3  sm:mt-5">
                            <h3 class="text-lg leading-6 text-center font-medium text-gray-900" id="modal-title">
                                Do you want to create a support ticket?
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-center text-gray-500">
                                    To create a ticket, please fill out the form below. We will get back to you as soon
                                    as possible.
                                </p>
                            </div>

                            <form class="space-y-8 "
                                  action="{{url("tickets")}}" method="post"
                                  onkeydown="return event.key !== 'Enter';"
                            >
                                @csrf

                                <div class="space-y-8 divide-y divide-gray-200">
                                    <div>

                                        <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                                            <div class="sm:col-span-6">
                                                <label for="title" class="block text-sm font-medium text-gray-700">
                                                    Title</label>
                                                <div class="mt-1">
                                                    <input type="text" name="title" id="title"
                                                           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm">
                                                </div>
                                                @error('title')
                                                <p class="mt-2 text-sm text-red-600">{{$message}}</p>
                                                @enderror
                                            </div>


                                            <div class="sm:col-span-6">
                                                <label for="description"
                                                       class="block text-sm font-medium text-gray-700">Description</label>
                                                <div class="mt-1">
                                                    <textarea id="description" name="description" rows="3"
                                                              class="block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm"></textarea>
                                                </div>
                                                @error('description')
                                                <p class="mt-2 text-sm text-red-600">{{$message}}</p>
                                                @enderror
                                                <p class="mt-2 text-sm text-gray-500">
                                                    Brief description for your ticket.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="pt-5">
                                    <div class="flex justify-end">
                                        <button type="button" x-on:click="showModal = false"
                                                class="rounded-md border border-gray-300 bg-white py-2 px-4 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2">
                                            Cancel
                                        </button>
                                        <button type="submit"
                                                class="ml-3 inline-flex justify-center rounded-md border border-transparent bg-teal-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2">
                                            Save
                                        </button>
                                    </div>
                                </div>
                            </form>


                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

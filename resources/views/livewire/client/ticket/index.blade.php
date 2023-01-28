<div class="mt-8 flex flex-col">

    <div class="flex justify-between mb-4">
        <div class="mt-1 flex-1">
            <input wire:model="search" type="search" name="datatable-search" id="datatable-search"
                   class="max-w-xs shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md"
                   placeholder="Search">
        </div>

        <div class="relative flex items-start">
            <div class="flex items-center">
                <input id="pending" aria-describedby="pending" type="checkbox"
                       wire:model="pending"
                       wire:click="onPendingClick"
                       class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-blue-300 rounded">
            </div>
            <div class="ml-3 text-sm mr-4">
                <label for="pending" class="font-medium text-gray-700">Pending</label>
            </div>

            <div class="flex items-center">
                <input id="resolved" aria-describedby="resolved" type="checkbox"
                       wire:model="resolved"
                       wire:click="onResolvedClick"
                       class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-blue-300 rounded">
            </div>
            <div class="ml-3 text-sm">
                <label for="resolved" class="font-medium text-gray-700">Resolved</label>
            </div>
        </div>
    </div>


    <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
            <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                <table class="min-w-full divide-y divide-gray-300">
                    <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                            ID
                        </th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                            Title
                        </th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                            Description
                        </th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                            Status
                        </th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">

                            <div>
                                <button wire:click="toggleOrder" class="flex items-center">
                                    Date Created

                                    @if($orderByDesc)
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                             class="w-5 h-5">
                                            <path fill-rule="evenodd"
                                                  d="M10 5a.75.75 0 01.75.75v6.638l1.96-2.158a.75.75 0 111.08 1.04l-3.25 3.5a.75.75 0 01-1.08 0l-3.25-3.5a.75.75 0 111.08-1.04l1.96 2.158V5.75A.75.75 0 0110 5z"
                                                  clip-rule="evenodd"/>
                                        </svg>
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                             class="w-5 h-5">
                                            <path fill-rule="evenodd"
                                                  d="M10 15a.75.75 0 01-.75-.75V7.612L7.29 9.77a.75.75 0 01-1.08-1.04l3.25-3.5a.75.75 0 011.08 0l3.25 3.5a.75.75 0 11-1.08 1.04l-1.96-2.158v6.638A.75.75 0 0110 15z"
                                                  clip-rule="evenodd"/>
                                        </svg>
                                    @endif
                                </button>

                            </div>


                        </th>
                        <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                            <span class="sr-only">View</span>
                        </th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                    @foreach($tickets as $ticket)

                        <tr>
                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                {{$ticket->id}}
                            </td>

                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                {{$ticket->title}}
                            </td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                {{Str::limit($ticket->description, 40)}}

                            </td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                @if($ticket->is_open)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                    Pending
                                </span>
                                @else($ticket->is_open)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Resolved
                                </span>
                                @endif
                            </td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                {{$ticket->created_at->format('d/m/Y')}}
                            </td>
                            <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                <a href="#" class="text-teal-600 hover:text-teal-900">View<span
                                            class="sr-only">View</span></a>
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
            <div class="mt-8">
                {{$tickets->links()}}
            </div>
        </div>
    </div>
</div>

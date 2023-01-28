<div x-data="{ showModal: false }">
    <div class="max-w-7xl mx-auto my-12 px-4 sm:px-6 lg:px-8">
        <div class="overflow-hidden bg-white shadow sm:rounded-lg">

            <div class="px-4 py-5 sm:px-6 flex justify-between">
                <div>
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Ticket Information</h3>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500">View ticket details and add comments</p>
                </div>

                <div>
                    @if($ticket->is_open)
                        <button type="button"
                                x-on:click="showModal = true"
                                class="inline-flex items-center justify-center rounded-md border border-transparent bg-teal-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 sm:w-auto">
                            Resolve Ticket
                        </button>
                    @endif
                </div>
            </div>
            <div class="border-t border-gray-200 px-4 py-5 sm:p-0">
                <dl class="sm:divide-y sm:divide-gray-200">
                    <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Ticket ID</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{$ticket->id}}</dd>
                    </div>
                    <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Title</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{$ticket->title}}</dd>
                    </div>
                    <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Created By</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">{{$ticket->user->name}}</dd>
                    </div>

                    <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Status</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">

                            @if($ticket->is_open == 1)
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        Pending
                                    </span>
                            @elseif($ticket->is_open == 0)
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Resolved
                                    </span>
                            @endif

                        </dd>
                    </div>
                    <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Description</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                            {{$ticket->description}}
                        </dd>
                    </div>
                    <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Comments</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">


                            <div>
                                <div class="sm:col-span-6">
                                    <div class="mt-1">
                                                    <textarea id="comment" name="comment" rows="3"
                                                              wire:model="comment"
                                                              placeholder="Add a comment..."
                                                              class="block w-full rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 sm:text-sm"></textarea>
                                    </div>
                                    @error('comment')
                                    <p class="mt-2 text-sm text-red-600">{{$message}}</p>
                                    @enderror

                                </div>

                                <div class="pt-5">
                                    <div class="flex justify-end">
                                        <button type="button" wire:click="addTicketReply"
                                                class="ml-3 inline-flex justify-center rounded-md border border-blue-300 shadow-sm
                                                    outline-blue-600 py-2 px-4 text-sm font-medium shadow-sm hover:bg-gray-100
                                                    focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                            Add Comment
                                        </button>
                                    </div>
                                </div>


                            </div>

                            <div class="my-4">
                                <ul role="list" class="divide-y divide-gray-200 max-h-96 overflow-auto">

                                    @foreach($ticketReplies as $reply )
                                        <li class="py-4">
                                            <div class="flex space-x-3">
                                                <div class="flex-1 space-y-1">
                                                    <div class="flex items-center justify-between">
                                                        <h3 class="text-sm font-medium">
                                                            {{$reply->user->name}}

                                                            @if($reply->user->isAdmin())
                                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                                        Admin
                                                                    </span>
                                                            @endif
                                                        </h3>
                                                        <p class="text-sm text-gray-500">
                                                            {{$reply->created_at->diffForHumans()}}
                                                        </p>
                                                    </div>
                                                    <p class="text-sm text-gray-500">
                                                        {{$reply->reply}}
                                                    </p>
                                                </div>
                                            </div>
                                        </li>

                                    @endforeach
                                </ul>
                            </div>
                        </dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>


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
                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-teal-100">
                        <!-- Heroicon name: outline/check -->
                        <svg class="h-6 w-6 text-teal-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M5 13l4 4L19 7"/>
                        </svg>

                    </div>
                    <div class="mt-3 text-center sm:mt-5">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                            Are you sure?
                        </h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">
                                Please confirm if you would like to resolve the ticket
                            </p>
                        </div>
                    </div>
                </div>
                <div class="mt-5 sm:mt-6 sm:grid sm:grid-cols-2 sm:gap-3 sm:grid-flow-row-dense">
                    <button type="button"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-teal-600 text-base font-medium text-white hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 sm:col-start-2 sm:text-sm">
                        Resolve
                    </button>
                    <button type="button" @click="showModal=false"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 sm:mt-0 sm:col-start-1 sm:text-sm">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>

    <x-flash-message></x-flash-message>

</div>

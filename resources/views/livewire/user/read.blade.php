@push('styles')
    <style>
        p.text-sm.text-gray-700.leading-5 {
            display: none;
        }
    </style>
@endpush

<div>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

        <div class="bg-white overflow-hidden rounded-lg shadow rounded-lg">

            {{-- alert --}}
            <div class="m-4 ">
                @if (session()->has('success'))
                    <div
                        x-data="{ show: true }"
                        x-show="show"
                        x-transition
                        x-init="setTimeout(() => show = false, 3000)"
                        class="alert-remove p-4 mt-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" 
                        role="alert"
                    >{{ session('success') }}</div>
                @endif

                @if (session()->has('error'))
                    <div
                        x-data="{ show: true }"
                        x-show="show"
                        x-transition
                        x-init="setTimeout(() => show = false, 3000)"
                        class="alert-remove p-4 mt-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" 
                        role="alert"
                    >{{ session('error') }}</div>
                @endif
            </div>

            {{-- table header --}}
            <div class="m-4">
                {{-- caption --}}
                <div class="mb-4 text-lg font-semibold text-left text-gray-900 bg-white dark:text-white dark:bg-gray-800">
                    <h5 class="text-lg font-medium text-gray-900 dark:text-white">Manage User Account</h5>
                    <p class="mt-1 mb-2 text-gray-500 dark:text-gray-400 font-normal text-sm">Effortlessly view, edit, and manage user accounts and profiles.</p>
                </div>

                {{-- search and button add --}}
                <div class="relative bg-white dark:bg-gray-800 rounded-lg">
                    <div class="flex flex-col items-center justify-between space-y-3 md:flex-row md:space-y-0 md:space-x-4">
                        
                        {{-- search  --}}
                        <div class="w-full md:w-1/2">
                            <form class="flex items-center">
                                <label for="simple-search" class="sr-only">Search</label>
                                <div class="relative w-full">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" /></svg>
                                    </div>
                                    <input wire:model='search' type="text" id="simple-search" class="block w-full p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search" required="">
                                </div>
                            </form>
                        </div>

                        {{-- button add --}}
                        <div class="flex flex-col items-stretch justify-end flex-shrink-0 w-full space-y-2 md:w-auto md:flex-row md:space-y-0 md:items-center md:space-x-3">
                            <a href="{{ Route('user.create') }}" type="button" class="flex items-center justify-center px-4 py-2 text-sm font-medium text-white rounded-lg bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                                <svg class="h-3.5 w-3.5 mr-2" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path clip-rule="evenodd" fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" /></svg>
                                Add User Account
                            </a>
                        </div>

                    </div>
                </div>
            </div>

            {{-- table --}}
            <div class="m-4 relative overflow-x-auto overflow-y-hidden rounded-lg shadow-sm">
                @if($users->isEmpty())
                    <div class="m-4">
                        <div class="flex flex-col justify-center items-center px-6 mx-auto xl:px-0 dark:bg-gray-900">
                            <div class="block max-w-sm">
                                <img src="/assets/illustrations/no-data.svg" alt="astronaut image">
                            </div>
                            <div class="text-center xl:max-w-4xl">
                                <h1 class="mb-3 text-2xl font-bold leading-tight text-gray-900 sm:text-4xl lg:text-5xl dark:text-white">Data not found</h1>
                                <p class="mb-5 text-base font-normal text-gray-500 md:text-lg dark:text-gray-400">Oops! I'm sorry, cannot find the data you're searching for.</p>
                            </div>
                        </div>
                    </div>
                @else
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="p-4"></th>
                                <th scope="col" class="px-6 py-3">
                                    Role
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Name
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Gender
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Phone
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ( $users as $index => $user )
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <th class="px-4 py-3 font-medium text-xs text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $users->firstItem() + $index }}
                                    </th>
                                    <th class="px-6 py-4">
                                        @foreach ($user->roles as $role)
                                            @if( $role->name == 'coordinator')
                                                <p class="flex justify-center bg-green-100 text-green-800 text-xs font-medium mr-0.5 mb-1 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">Coordinator</p>
                                            @elseif($role->name == 'lecturer')
                                                <p class="flex justify-center bg-purple-100 text-purple-800 text-xs font-medium mr-0.5 mb-1 px-2.5 py-0.5 rounded dark:bg-purple-900 dark:text-purple-300">Lecturer</p>
                                            @elseif($role->name == 'student')
                                                <p class="flex justify-center bg-yellow-100 text-yellow-800 text-xs font-medium mr-0.5 mb-1 px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300">Student</p>
                                            @elseif($role->name == 'kaprodi')
                                                <p class="flex justify-center bg-pink-100 text-pink-800 text-xs font-medium mr-0.5 mb-1 px-2.5 py-0.5 rounded dark:bg-pink-900 dark:text-pink-300">Kaprodi</p>
                                            @endif
                                        @endforeach
                                    </th>
                                    <th class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        <div class="flex items-center">
                                            @if($user->avatar)
                                                <div class="inline-block w-10 h-10 overflow-hidden bg-gray-300 rounded-full">
                                                    <img class="object-cover w-10 h-10" src="{{ asset('storage/avatars/'.$user->avatar) }}" alt="avatar"/>
                                                </div>
                                            @else                    
                                                <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=e6f0ff&rounded=true" alt="avatar" width="40">
                                            @endif
                                            <div class="px-6">
                                                <div class="text-light font-semibold text-gray-900">{{ $user->name }}</div>
                                                <div class="font-normal text-gray-500">{{ $user->email }}</div>
                                            </div>
                                        </div>
                                    </th>
                                    <td class="px-6 py-4">
                                        @if($user->gender == 'male')
                                            <p class="flex items-center text-xs font-medium text-gray-900 dark:text-white">
                                                <span class="flex w-2.5 h-2.5 bg-blue-600 rounded-full mr-1.5 flex-shrink-0"></span>
                                                Male
                                            </p>
                                        @else
                                            <p class="flex items-center text-xs font-medium text-gray-900 dark:text-white">
                                                <span class="flex w-2.5 h-2.5 bg-red-300 rounded-full mr-1.5 flex-shrink-0"></span>
                                                Female
                                            </p>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $user->phone }}
                                    </td>
                                    <td class="px-6 py-4 space-x-1 whitespace-nowrap">
                                        <a data-tooltip-target="tooltip-edit" href="" wire:click="editIdUser({{ $user->id }})" wire:click.prevent class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white rounded-lg bg-yellow-300 hover:bg-yellow-500 focus:ring-4 focus:ring-yellow-300 dark:bg-yellow-300 dark:hover:bg-yellow-300 dark:focus:ring-yellow-300">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"></path><path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd"></path></svg>
                                        </a>
                                        <a data-tooltip-target="tooltip-delete" href="" wire:click="deleteIdUser({{ $user->id }})" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-red-600 rounded-lg hover:bg-red-800 focus:ring-4 focus:ring-red-300 dark:focus:ring-red-900" x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div id="tooltip-edit" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                        Edit
                        <div class="tooltip-arrow" data-popper-arrow></div>
                    </div>
                    <div id="tooltip-delete" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                        Delete
                        <div class="tooltip-arrow" data-popper-arrow></div>
                    </div>
                @endif
            </div>

            {{-- table footer --}}
            <div class="m-4">
                {{ $users->links() }}
            </div>

            {{-- delete modal --}}
            <x-modal wire:ignore.self name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
                <div class="p-6">
                    <div class="p-2 text-center">
                        <svg aria-hidden="true" class="mx-auto mb-4 text-gray-400 w-14 h-14 dark:text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Are you sure you want to delete <span class="text-gray-900 font-semibold">{{ $deleteIdUserEmail }}</span>?</h3>
                    </div>

                    <div class="flex justify-end">
                        <x-secondary-button x-on:click="$dispatch('close')">
                            {{ __('Cancel') }}
                        </x-secondary-button>

                        <x-danger-button class="ml-3" wire:click.prevent="deleteUser()" x-on:click="$dispatch('close')">
                            <span wire:loading.remove>{{ __('Delete') }}</span>
                            <span wire:loading>
                                <svg aria-hidden="true" class="w-5 h-5 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                                    <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                                </svg>
                            </span>
                        </x-danger-button>
                    </div>
                </div>
            </x-modal>

        </div>

    </div>
</div>
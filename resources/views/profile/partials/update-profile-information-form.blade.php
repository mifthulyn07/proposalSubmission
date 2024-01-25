<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>

        @if (session()->has('warning'))
            <div
                x-data="{ show: true }"
                x-show="show"
                x-transition
                x-init="setTimeout(() => show = false, 3000)"
                class="mb-2 flex align-center justify-center alert-remove p-4 text-sm text-yellow-800 rounded-lg bg-yellow-50 dark:bg-gray-800 dark:text-yellow-400" 
                role="alert"
            >
                <div class="flex items-center justify-center">
                    <svg class="flex-shrink-0 inline w-4 h-4 mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20"><path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/></svg>
                </div>
                <span class="font-bold mr-1">Warning alert!</span> {{ session('warning') }}
            </div>
        @endif
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-6 space-y-6" id="complete-profile">
        @csrf
        @method('patch')

        {{-- email --}}
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>
        
        {{-- name --}}
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        {{-- gender --}}
        <div>
            <x-input-label for="gender" :value="__('Gender')" />
            <select name="gender" id="gender" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                @if (old('gender', $user->gender) == "female")
                    <option value="male">Male</option>
                    <option value="female" selected>Female</option>
                @else
                    <option value="male" selected>Male</option>
                    <option value="female">Female</option>
                @endif
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('gender')" />
        </div>

        {{-- phone --}}
        <div>
            <x-input-label for="phone" :value="__('Phone')" />
            <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" :value="old('phone', $user->phone)" required autocomplete="phone" />
            <x-input-error class="mt-2" :messages="$errors->get('phone')" />
        </div>

        {{-- form student & lecturer --}}
        @if($user->lecturer)
            <div>
                <x-input-label for="nip" :value="__('NIP')" />
                <x-text-input id="nip" name="nip" type="text" class="mt-1 block w-full" :value="old('nip', $user->lecturer->nip)" required autocomplete="nip" />
                <x-input-error class="mt-2" :messages="$errors->get('nip')" />
            </div>
            <div>
                <x-input-label for="expertise" :value="__('Expertise')" />
                <x-text-input id="expertise" name="expertise" type="text" class="mt-1 block w-full" :value="old('expertise', $user->lecturer->expertise)" required autocomplete="expertise" />
                <x-input-error class="mt-2" :messages="$errors->get('expertise')" />
            </div>
        @elseif($user->student)
            <div>
                <x-input-label for="nim" :value="__('NIM')" />
                <x-text-input id="nim" name="nim" type="text" class="mt-1 block w-full" :value="old('nim', $user->student->nim)" required autocomplete="nim" />
                <x-input-error class="mt-2" :messages="$errors->get('nim')" />
            </div>

            <div>
                <x-input-label for="class" :value="__('Class')" />
                <x-text-input id="class" name="class" type="text" class="mt-1 block w-full" :value="old('class', $user->student->class)" required autocomplete="class" />
                <x-input-error class="mt-2" :messages="$errors->get('class')" />
            </div>
           
            <div>
                <x-input-label for="lecturer_id" :value="__('Supervisor')" />
                <select name="lecturer_id" id="lecturer_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                    <option selected hidden value="">Select Supervisor</option>
                    @foreach($lecturers as $lecturer)
                        @if($user->student->lecturer)
                            @if($user->student->lecturer->id == $lecturer->id)
                                <option selected value="{{ $lecturer->id }}">{{ $lecturer->user->name }}</option>    
                                @php continue @endphp 
                            @endif
                        @endif
                        <option value="{{ $lecturer->id }}">{{ $lecturer->user->name }}</option>
                    @endforeach
                </select>
                <x-input-error class="mt-2" :messages="$errors->get('lecturer_id')" />
            </div>
        @endif
        
        <div class="flex items-center gap-4">
            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm sm:w-auto px-4 py-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Save</button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>

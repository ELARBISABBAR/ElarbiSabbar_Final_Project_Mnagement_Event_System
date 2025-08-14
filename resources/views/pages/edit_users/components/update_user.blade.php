<!-- Button trigger modal -->
<div >
    <button {{ $user->role == "admin" ? 'disabled' : ""  }} id="buttonModal{{ $user->id }}" type="button" class=" bg-primary text-light  my-1 px-3 py-2 rounded-lg cursor-not-allowed"
        data-bs-toggle="modal" data-bs-target="#{{ $user->id }}">
        Update
    </button>

</div>

<!-- Modal -->
<div class="modal fade" id="{{ $user->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">update User</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('user.update', $user) }}">
                    @csrf
                    @method('PUT')

                    <!-- Name -->
                    <div>
                        <x-input-label class="pl-1 text-start" for="name" :value="__('Name')" />
                        <x-text-input id="name" class="block mt-1 w-full border-2 " placeholder="insert your name"
                            type="text" name="name" value="{{ old('name', $user->name) }}" autofocus
                            autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Email Address -->
                    <div class="mt-4">
                        <x-input-label class="pl-1 text-start" for="email" :value="__('Email')" />
                        <x-text-input id="email" value="{{ old('email', $user->email) }}"
                            class="block mt-1 w-full rounded-lg  border-2" placeholder="insert your  email"
                            type="email" name="email" autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>
                    <!-- phone -->
                    <div class="mt-4">
                        <x-input-label class="pl-1 text-start" for="phone" :value="__('phone')" />
                        <x-text-input id="phone" class="block mt-1 w-full border-2  rounded-lg  "
                            placeholder="insert your phone number" type="number" name="phone"
                            value="{{ old('phone', $user->phone) }}" autocomplete="username" />
                        <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                    </div>
                    <!-- role -->
                    <div class="mt-4">
                        <x-input-label class="pl-1 text-start" for="role" :value="__('role')" />
                        <select name="role" id="role"
                            class="block mt-1 w-full border-2 rounded-lg border-[#d1d5db]" type="text"
                            autocomplete="username">
                            <option value="" selected disabled>
                                <p class="text-[#d1d5db]">Organizer/attendee</p>
                            </option>
                            <option {{ $user->role == 'organizer' ? 'selected' : '' }} value="organizer">Organizer
                            </option>
                            <option {{ $user->role == 'attendee' ? 'selected' : '' }} value="attendee">Attendee
                            </option>
                        </select>

                        <x-input-error :messages="$errors->get('role')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end mt-4">

                        <x-primary-button class="ms-4">
                            {{ __('Register') }}
                        </x-primary-button>
                    </div>
                </form>

            </div>

        </div>
    </div>
</div>

<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('navigation.team') }}
            </h2>
            @if (Auth::user()->isAdmin())
                @if (session('status') === 'user-added')
                    <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                        class="text-sm text-gray-600 dark:text-gray-400">{{ __('User added.') }}</p>
                @endif
                @if (session('status') === 'user-updated')
                    <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                        class="text-sm text-gray-600 dark:text-gray-400">{{ __('User updated.') }}</p>
                @endif
                <x-secondary-button x-data=""
                    x-on:click.prevent="$dispatch('open-modal', 'add-new-user')">
                    {{ __('Add new user') }}
                </x-secondary-button>
            @endif
        </div>
    </x-slot>

    <x-modal name="add-new-user" focusable>
        <form class="p-6" method="POST" action="{{ route('team.createNewUser') }}">
            @csrf

            <!-- Name -->
            <div>
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')"
                    required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                    required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" />

                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                    autocomplete="new-password" />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

                <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                    name="password_confirmation" required autocomplete="new-password" />

                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <!-- Role -->
            <div class="mt-4">
                <x-input-label for="role_id" :value="__('Role')" />

                <x-select name="role_id">
                    @foreach (App\Models\Role::all() as $role)
                        <option value="{{ $role['id'] }}">
                            {{ __(ucfirst($role['value'])) }}</option>
                    @endforeach
                </x-select>

            </div>

            <div class="flex items-center justify-end mt-4">
                <x-primary-button class="ml-4">
                    {{ __('Add') }}
                </x-primary-button>
            </div>
        </form>
    </x-modal>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <details class="mt-6" open>
                <summary
                    class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full">
                    {{ __('Admins') }}</summary>
                @foreach ($usersList[0] as $user)
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mt-3">
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            {{ $user->user['name'] }}
                            @if (Auth::user()->isAdmin())
                                <x-secondary-button class="ml-4" x-data=""
                                    x-on:click.prevent="$dispatch('open-modal', 'edit-user-{{ $user->user['id'] }}')">
                                    {{ __('Edit') }}
                                </x-secondary-button>
                            @endif

                            <x-modal name="edit-user-{{ $user->user['id'] }}" focusable>
                                <form method="post" action="{{ route('team.editUser', $user->user['id']) }}"
                                    class="p-6">
                                    @csrf
                                    @method('post')

                                    <div class="mt-6">
                                        <x-input-label for="name" :value="__('Имя')" />
                                        <x-text-input id="name" name="name" type="text"
                                            class="mt-1 block w-full" :value="old('name', $user->user->name)" required autofocus
                                            autocomplete="name" />
                                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                                    </div>

                                    <div class="mt-6">
                                        <input type="checkbox" id="admin" name="is_admin"
                                            {{ $user->user->isAdmin() ? 'checked' : '' }}>
                                        <label for="admin">{{ __('Admin') }}</label>
                                    </div>

                                    <div>
                                        <input type="checkbox" id="worker" name="is_worker"
                                            {{ $user->user->isWorker() ? 'checked' : '' }}>
                                        <label for="worker">{{ __('Worker') }}</label>
                                    </div>

                                    <div>
                                        <input type="checkbox" id="user" name="is_user"
                                            {{ $user->user->isUser() ? 'checked' : '' }}>
                                        <label for="user">{{ __('User') }}</label>
                                    </div>

                                    <x-secondary-button x-on:click="$dispatch('close')" class="mt-6">
                                        {{ __('Cancel') }}
                                    </x-secondary-button>

                                    <x-accept-button class="ml-3">
                                        {{ __('Edit') }}
                                    </x-accept-button>
                                </form>
                            </x-modal>
                        </div>
                    </div>
                @endforeach
            </details>
            <details class="mt-6" open>
                <summary
                    class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full">
                    {{ __('Workers') }}</summary>
                @foreach ($usersList[1] as $user)
                    @if ($user->user->isAdmin())
                        @continue
                    @endif
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mt-3">
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            {{ $user->user['name'] }}
                            @if (Auth::user()->isAdmin())
                                <x-secondary-button class="ml-4" x-data=""
                                    x-on:click.prevent="$dispatch('open-modal', 'edit-user-{{ $user->user['id'] }}')">
                                    {{ __('Edit') }}
                                </x-secondary-button>
                            @endif

                            <x-modal name="edit-user-{{ $user->user['id'] }}" focusable>
                                <form method="post" action="{{ route('team.editUser', $user->user['id']) }}"
                                    class="p-6">
                                    @csrf
                                    @method('post')

                                    <div class="mt-6">
                                        <x-input-label for="name" :value="__('Имя')" />
                                        <x-text-input id="name" name="name" type="text"
                                            class="mt-1 block w-full" :value="old('name', $user->user->name)" required autofocus
                                            autocomplete="name" />
                                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                                    </div>

                                    <div class="mt-6">
                                        <input type="checkbox" id="admin" name="is_admin"
                                            {{ $user->user->isAdmin() ? 'checked' : '' }}>
                                        <label for="admin">{{ __('Admin') }}</label>
                                    </div>

                                    <div>
                                        <input type="checkbox" id="worker" name="is_worker"
                                            {{ $user->user->isWorker() ? 'checked' : '' }}>
                                        <label for="worker">{{ __('Worker') }}</label>
                                    </div>

                                    <div>
                                        <input type="checkbox" id="user" name="is_user"
                                            {{ $user->user->isUser() ? 'checked' : '' }}>
                                        <label for="user">{{ __('User') }}</label>
                                    </div>

                                    <x-secondary-button x-on:click="$dispatch('close')" class="mt-6">
                                        {{ __('Cancel') }}
                                    </x-secondary-button>

                                    <x-accept-button class="ml-3">
                                        {{ __('Edit') }}
                                    </x-accept-button>
                                </form>
                            </x-modal>
                        </div>
                    </div>
                @endforeach
            </details>

            <details>
                <summary
                    class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full">
                    {{ __('Users') }}</summary>
                @foreach ($usersList[2] as $user)
                    @if ($user->user->isAdmin() || $user->user->isWorker())
                        @continue
                    @endif
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mt-3">
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            {{ $user->user['name'] }}
                            @if (Auth::user()->isAdmin())
                                <x-secondary-button class="ml-4" x-data=""
                                    x-on:click.prevent="$dispatch('open-modal', 'edit-user-{{ $user->user['id'] }}')">
                                    {{ __('Edit') }}
                                </x-secondary-button>
                            @endif

                            <x-modal name="edit-user-{{ $user->user['id'] }}" focusable>
                                <form method="post" action="{{ route('team.editUser', $user->user['id']) }}"
                                    class="p-6">
                                    @csrf
                                    @method('post')

                                    <div class="mt-6">
                                        <x-input-label for="name" :value="__('Имя')" />
                                        <x-text-input id="name" name="name" type="text"
                                            class="mt-1 block w-full" :value="old('name', $user->user->name)" required autofocus
                                            autocomplete="name" />
                                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                                    </div>

                                    <div class="mt-6">
                                        <input type="checkbox" id="admin" name="is_admin"
                                            {{ $user->user->isAdmin() ? 'checked' : '' }}>
                                        <label for="admin">{{ __('Admin') }}</label>
                                    </div>

                                    <div>
                                        <input type="checkbox" id="worker" name="is_worker"
                                            {{ $user->user->isWorker() ? 'checked' : '' }}>
                                        <label for="worker">{{ __('Worker') }}</label>
                                    </div>

                                    <div>
                                        <input type="checkbox" id="user" name="is_user"
                                            {{ $user->user->isUser() ? 'checked' : '' }}>
                                        <label for="user">{{ __('User') }}</label>
                                    </div>

                                    <x-secondary-button x-on:click="$dispatch('close')" class="mt-6">
                                        {{ __('Cancel') }}
                                    </x-secondary-button>

                                    <x-accept-button class="ml-3">
                                        {{ __('Edit') }}
                                    </x-accept-button>
                                </form>
                            </x-modal>
                        </div>
                    </div>
                @endforeach
            </details>
        </div>
    </div>

</x-app-layout>

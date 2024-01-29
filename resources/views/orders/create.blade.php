<!-- create_order_form.blade.php -->
<form method="post" action="{{ route('orders.store') }}" class="mt-6 space-y-6">
    @csrf
    @method('post')

    {{-- orders.create.blade.php --}}
    @extends('layouts.app')

    @section('content')
        @if (Auth::user()->isWorker() || Auth::user()->isAdmin())
            <x-modal name="add-new-task" focusable>
                <div class="p-6">
                    <header>
                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                            {{ __('Create task') }}
                        </h2>

                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            {{ __('To create a task, fill in the fields below.') }}
                        </p>
                    </header>
                    <form method="post" action="{{ route('orders.store') }}" class="mt-6 space-y-6">
                        @csrf
                        @method('post')

                        <div class="max-w-xl">
                            <x-input-label for="username" :value="__('Specify the name client')" />
                            <x-text-input id="username" name="username" type="text" class="mt-1 block w-full" required
                                          autofocus autocomplete="username" />
                        </div>

                        <div class="max-w-xl">
                            <x-input-label for="type_work" :value="__('Specify the type of work')" />
                            <x-text-input id="typeworks" name="typeworks" type="text" class="mt-1 block w-full" list="typeworks"
                                          required autocomplete="typeworks" />
                            <datalist id="typeworks">
                                <option value="Изготовление импланта">
                                <option value="Изготовление протезов">
                                <option value="Изготовление виниров">
                                <option value="Изготовление циркониевых коронок">
                                <option value="Изготовление керамических накладок">
                                <option value="Другое">
                            </datalist>
                        </div>

                        <div class="max-w-xl">
                            <x-input-label for="summ" :value="__('Specify a sum')" />
                            <x-text-input id="summ" name="summ" type="text" class="mt-1 block w-full" required
                                          autofocus autocomplete="summ" />
                        </div>

                        <div class="max-w-xl">
                            <x-input-label for="executor" :value="__('Specify the responsible persons')" />
                            <x-text-input id="executor" name="executor[]" type="text" class="mt-1 block w-full" list="name_persons"
                                          required autocomplete="executor" multiple />
                            <datalist id="name_persons">
                                <option value="Ваня Петров">
                                <option value="Саша Иванов">
                                <option value="Дмитрий Усачев">
                            </datalist>
                        </div>
                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Create') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </x-modal>
        @else
            <p>У вас нет доступа к созданию заказов.</p>
        @endif
    @endsection


    <div class="flex items-center gap-4">
        <x-primary-button>{{ __('Create') }}</x-primary-button>
    </div>
</form>

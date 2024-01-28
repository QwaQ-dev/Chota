<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('navigation.warehouse') }}
            </h2>
            @if (Auth::user()->isWorker())
                @if (session('status') === 'task-added')
                    <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                       class="text-sm text-gray-600 dark:text-gray-400">{{ __('Task added.') }}</p>
                @endif
                <x-secondary-button x-data="" x-on:click.prevent="$dispatch('open-modal', 'add-new-task')">
                    {{ __('Add new product') }}
                </x-secondary-button>
            @endif
        </div>
    </x-slot>


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
            <form method="post" action="{{ route('warehouse.store') }}" class="mt-6 space-y-6">
                @csrf
                @method('post')

                <div class="max-w-xl">
                    <x-input-label for="product_name" :value="__('Specify the name product')"/>
                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" required autofocus
                                  autocomplete="product_name"/>
                </div>

                <div class="max-w-xl">
                    <x-input-label for="quantity_product" :value="__('Specify the quantity of the product')"/>
                    <x-text-input id="quantity" name="quantity" type="numeric" class="mt-1 block w-full" required
                                  autofocus autocomplete="quantity_product"/>
                </div>

                <div class="max-w-xl">
                    <x-input-label for="description" :value="__('Specify the delivery date')"/>
                    <input type="date" id="delivery"
                           class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                           name="delivery" value="{{ date('Y-m-d', strtotime('-1 month')) }}" min="2023-01-01"
                           max="2033-12-31" style="border-radius: 0.5em;">
                </div>

                <div class="flex items-center gap-4">
                    <x-primary-button type="submit">{{ __('Add') }}</x-primary-button>
                </div>


            </form>
        </div>
    </x-modal>

    <div class="mt-8">
        <div class="overflow-x-auto bg-gray-800 dark:bg-gray-700 shadow-md rounded-lg">
            <table class="min-w-full bg-gray-800 dark:bg-gray-1100 text-white">
                <thead>
                <tr>
                    <th class="py-2">#</th>
                    <th class="py-2">{{ __('Product Name') }}</th>
                    <th class="py-2">{{ __('Quantity') }}</th>
                    <th class="py-2">{{ __('Delivery Date') }}</th>
                </tr>
                </thead>
                <!-- ... -->

                <tbody>
                @foreach ($warehouses as $warehouse)
                    <tr>
                        <th class="py-2">{{ $loop->iteration }}</th>
                        <th class="py-2">{{ $warehouse->name }}</th>
                        <th class="py-2">{{ $warehouse->quantity }}</th>
                        <th class="py-2">{{ $warehouse->delivery }}</th>
                        <th class="py-2">
                            <x-secondary-button class="ml-4" x-data=""
                                                x-on:click.prevent="$dispatch('open-modal', 'edit-item-{{ $warehouse->id }}')">{{ __('Edit') }}</x-secondary-button>
                        </th>
                    </tr>
                    <x-modal name="edit-item-{{ $warehouse->id }}" focusable>
                        <div class="p-6">
                            <header>
                                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                    {{ __('Create task') }}
                                </h2>
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                    {{ __('To create a task, fill in the fields below.') }}
                                </p>
                            </header>
                            <form method="post" action="{{ route('warehouse.update', $warehouse->id) }}"
                                  class="mt-6 space-y-6">
                                @csrf
                                @method('post')

                                <div class="mt-6 max-w-xl">
                                    <x-input-label for="name" :value="__('Specify the name product')"/>
                                    <x-text-input id="name" name="name" type="text"
                                                  class="mt-1 block w-full" :value="old('name', $warehouse->name)"
                                                  required autofocus
                                                  autocomplete="name"/>
                                    <x-input-error class="mt-2" :messages="$errors->get('name')"/>
                                </div>

                                <div class="mt-6 max-w-xl">
                                    <x-input-label for="quantity_product" :value="__('Specify the quantity of the product')"/>
                                    <x-text-input id="quantity" name="quantity" type="numeric"
                                                  class="mt-1 block w-full" :value="old('quantity', $warehouse->quantity)"
                                                  required autofocus
                                                  min="1" max="2147483647"
                                                  autocomplete="name"/>
                                    <x-input-error class="mt-2" :messages="$errors->get('quantity')"/>
                                </div>

                                <div class="mt-6 max-w-xl">
                                    <x-input-label for="description" :value="__('Specify the delivery date')"/>
                                    <x-text-input id="delivery" name="delivery" type="date"
                                                  class="mt-1 block" :value="old('quantity', $warehouse->delivery)"
                                                  required autofocus
                                                  autocomplete="name"/>
                                    <x-input-error class="mt-2" :messages="$errors->get('quantity')"/>
                                </div>

                                <x-secondary-button x-on:click="$dispatch('close')" class="mt-6">
                                    {{ __('Cancel') }}
                                </x-secondary-button>

                                <x-accept-button class="ml-3">
                                    {{ __('Edit') }}
                                </x-accept-button>
                            </form>
                        </div>
                    </x-modal>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>

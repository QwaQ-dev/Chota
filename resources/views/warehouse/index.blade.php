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
                    <x-input-label for="product_name" :value="__('Specify the name product')" />
                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" required autofocus autocomplete="product_name" />
                </div>

                <div class="max-w-xl">
                    <x-input-label for="quantity_product" :value="__('Specify the quantity of the product')" />
                    <x-text-input id="quantity" name="quantity" type="numeric" class="mt-1 block w-full" required autofocus autocomplete="quantity_product" />
                </div>

                <div>
                    <x-input-label for="description" :value="__('Specify the delivery date')" />
                    <input type="date" id="delivery" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" name="delivery" value="{{ date('Y-m-d', strtotime('-1 month')) }}" min="2023-01-01" max="2033-12-31" style="border-radius: 0.5em;">
                </div>

                <div class="flex items-center gap-4">
                    <x-primary-button type="submit">{{ __('Add') }}</x-primary-button>
                </div>
            </form>
        </div>
    </x-modal>


    @foreach ($warehouse as $warehouse)
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-10">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <div class="flex justify-between capitalize">
                    <div class="flex justify-between">
                        <span>{{ isset($users[warehouse->user_id - 1]) ? $users[warehouse->user_id - 1]->name : 'N/A' }}</span>
                        <div class="gray line"></div>
                        <span>{{ warehouse->cabinet }} {{ __('navigation.task.cabinet') }}</span>
                    </div>
                    <div class="flex justify-end">
                    <span>
                        {{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $order->updated_at)->locale(App::currentLocale())->isoFormat('dddd, D MMMM H:mm') }}
                    </span>
                        <!-- Кнопки редактирования -->
                        @if (Auth::user()->isWorker() && $order->status_id == 1 && $order->performer_id == Auth::user()->id)
                            <div class="flex ml-2">
                                <form action="{{ route('task.completed', $order->id) }}" method="post">
                                    @csrf
                                    @method('patch')
                                    <x-primary-button name="accept" value="{{ $order->id }}">
                                        {{ __('navigation.task.done') }}
                                    </x-primary-button>
                                </form>
                                <form action="{{ route('task.update', $order->id) }}" method="post" class="ml-3">
                                    @csrf
                                    @method('patch')
                                    <x-primary-button name="refuse" value="{{ $order->id }}">
                                        {{ __('navigation.task.cancel') }}
                                    </x-primary-button>
                                </form>
                            </div>
                        @endif
                        <!-- Конец блока кнопок редактирования -->
                    </div>
                </div>
                <div class="mt-4">
                    <span>{{ $order->title }}</span>
                    <span>{{ $order->description }}</span>
                    @if ($order->status_id == 1)
                        <span class="flex justify-end mt-6 mr-2">{{ __('navigation.task.performer') }}:
                        {{ $workers[array_search($order->performer_id, array_column($workers, 'user_id'))]['name'] }}
                    </span>
                    @endif
                </div>
            </div>
        </div>
    @endforeach



</x-app-layout>

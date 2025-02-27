<x-layout title="Dashboard">
    <div class="mt-20">
        <x-title>{{ __('messages.orders') }}</x-title>
        <div class="mx-20">{{ $orders->links() }}</div>
        <div class="max-w-6xl mx-auto">
            <div class="flex flex-col">
                <div class="overflow-x-auto shadow-md sm:rounded-lg">
                    <div class="inline-block min-w-full align-middle">
                        <div class="overflow-hidden ">
                            <table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-700">
                                <thead class="bg-gray-100 dark:bg-gray-700">
                                    <tr>
                                        <th scope="col"
                                            class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                                            {{ __('messages.id') }}
                                        </th>
                                        <th scope="col"
                                            class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                                            {{ __('messages.customer_name') }}
                                        </th>
                                        <th scope="col"
                                            class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                                            {{ __('messages.customer_email') }}
                                        </th>
                                        <th scope="col"
                                            class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                                            {{ __('messages.created_at') }}
                                        </th>
                                        <th scope="col" class="p-4">
                                            <span class="sr-only">{{ __('messages.view') }}</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">

                                    @foreach ($orders as $order)
                                        <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                            <td
                                                class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                {{ $order->getKey() }}
                                            </td>

                                            <td
                                                class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                {{ $order->customer_name }}
                                            </td>

                                            <td
                                                class="py-4 px-6 text-sm font-medium text-gray-500 whitespace-nowrap dark:text-white">
                                                {{ $order->customer_email }}
                                            </td>

                                            <td
                                                class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                {{ $order->created_at }}
                                            </td>

                                            <td class="py-4 px-6 text-sm font-medium text-right whitespace-nowrap">
                                                <a href="{{ route('order.show', $order->getKey()) }}"
                                                    class="text-blue-600 dark:text-blue-500 hover:underline">{{ __('messages.view') }}</a>
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</x-layout>

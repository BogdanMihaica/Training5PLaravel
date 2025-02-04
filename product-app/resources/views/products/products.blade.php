<x-layout title="Dashboard">
    <div class="mt-20">
        <x-title>{{ __('messages.products') }}</x-title>
        <div class="mx-20">{{ $products->links() }}</div>
        <div class="max-w-6xl mx-auto">
            <div class="flex flex-col">
                <div class="overflow-x-auto shadow-md sm:rounded-lg">
                    <div class="inline-block min-w-full align-middle">
                        <div class="overflow-hidden ">
                            <table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-700">
                                <thead class="bg-gray-100 dark:bg-gray-700">
                                    <th scope="col"
                                        class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                                        {{ __('messages.id') }}
                                    </th>
                                    <th scope="col"
                                        class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                                        {{ __('messages.image') }}
                                    </th>
                                    <th scope="col"
                                        class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                                        {{ __('messages.product_title') }}
                                    </th>
                                    <th scope="col"
                                        class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                                        {{ __('messages.description') }}
                                    </th>
                                    <th scope="col"
                                        class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                                        {{ __('messages.price') }}
                                    </th>
                                    <th scope="col" class="p-4">
                                        <span class="sr-only">{{ __('messages.edit') }}</span>
                                    </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">

                                    @foreach ($products as $product)
                                        <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">

                                            <td
                                                class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                {{ $product->getKey() }}
                                            </td>

                                            <td
                                                class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                <img class="max-h-20 rounded-lg" src="{{ getImageUrl($product) }}"
                                                    alt="Product Image">
                                            </td>

                                            <td
                                                class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                <a class="text-blue-500"
                                                    href="{{ route('products.edit', $product) }}">{{ $product->title }}</a>
                                            </td>

                                            <td
                                                class=" py-4 px-6 text-sm font-medium text-gray-500 whitespace-nowrap dark:text-white">
                                                {{ $product->description }}
                                            </td>

                                            <td
                                                class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                {{ $product->price }}
                                            </td>

                                            <td class="py-4 px-6 text-sm font-medium text-right whitespace-nowrap">
                                                <form action="{{ route('products.destroy', $product) }}"
                                                    method="post">
                                                    @csrf

                                                    @method('DELETE')

                                                    <button
                                                        class="text-white py-3 px-3 bg-red-700 rounded-lg cursor-pointer hover:bg-red-800">
                                                        {{ __('messages.delete') }}
                                                    </button>
                                                </form>

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

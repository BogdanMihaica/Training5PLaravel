@php
$grandTotal = 0;
@endphp
<x-layout>
    <div class="mt-20 mx-10">
        <h1 class="text-xl"><strong>{{__('messages.customer_details')}}</strong></h1>
        <h2>{{__('messages.customer_name') .': '. $order->customer_name}}</h2>
        <h2>{{__('messages.customer_email') .': '. $order->customer_email}}</h2>
        <br>
        <table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-700">
            <thead class="bg-gray-100 dark:bg-gray-700">
                <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                    {{__('messages.id')}}
                </th>
                <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                    {{__('messages.image')}}
                </th>
                <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                    {{__('messages.product_title')}}
                </th>
                <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                    {{__('messages.description')}}
                </th>
                <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                    {{__('messages.price')}}
                </th>
                <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                    {{__('messages.quantity')}}
                </th>
                <th scope="col" class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                    {{__('messages.total')}}
                </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">

                @foreach ($products as $product)
                    <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">

                        <td class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $product->id }}
                        </td>

                        <td class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            <img class="max-h-20 rounded-lg" src="{{ getImageUrl($product) }}" alt="Product Image">
                        </td>

                        <td class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $product->title }}
                        </td>

                        <td class="py-4 px-6 text-sm font-medium text-gray-500 whitespace-nowrap dark:text-white">
                            {{ $product->description }}
                        </td>

                        <td class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $product->price }}
                        </td>

                        <td class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $product->pivot->quantity }}
                        </td>

                        <td class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $product->price * $product->pivot->quantity }}
                        </td>
                        @php
                        $grandTotal += $product->price * $product->pivot->quantity
                        @endphp
                    </tr>
                @endforeach
                <tr>
                    <td colspan="5" class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white"></td>
                    <td class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{__('messages.grand_total')}}
                    </td>
                    <td class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{$grandTotal}}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</x-layout>
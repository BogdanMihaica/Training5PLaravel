<x-skeleton title="Homepage">
    <div class="mt-20">
        <x-title>{{ __('messages.browse_products') }}</x-title>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 px-4 py-2">
            @foreach($products as $product)
            <div class="border border-gray-300 rounded-lg shadow-lg bg-white p-4 flex flex-col items-center text-center justify-between">
                <div class="">
                    <img class="max-h-70 rounded-lg" src="{{ findImage($product->id) }}" alt="Product Image">
                </div>
                <h2 class="text-lg font-semibold text-gray-800">{{ $product->title }}</h2>
                <p class="text-sm text-gray-600 mt-2">{{ $product->description }}</p>
                <p class="text-lg font-bold text-green-600 mt-4">${{ $product->price }}</p>
                <a class="mt-4 px-4 py-2 bg-slate-600 text-white rounded-lg hover:bg-slate-700 transition cursor-pointer"
                    href="/cart/add/{{ $product->id }}/"
                    onclick="this.href += document.querySelector('.select-{{$product->id}}').value;">{{ __('messages.add_to_cart') }}</a>

                <span>{{ __('messages.select_quantity') }}:
                    <select class="select-{{$product->id}}">
                        @for($i = 1; $i <= 10; $i++)
                            <option> {{ $i }} </option>
                            @endfor
                    </select>
                </span>
            </div>
            @endforeach
        </div>
        <div class="w-1/2 mx-auto">
            {{$products->links()}}
        </div>
    </div>
</x-skeleton>
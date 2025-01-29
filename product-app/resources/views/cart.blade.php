<x-skeleton title="Homepage">
    <h1 class="text-gray-900 text-4xl font-bold text-center my-10">Your shopping cart</h1>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 px-4">
        @foreach($products as $product)
        <div class="border border-gray-300 rounded-lg shadow-lg bg-white p-4 flex flex-col items-center text-center justify-between">
            <h2 class="text-lg font-semibold text-gray-800">{{ $product->title }}</h2>
            <p class="text-sm text-gray-600 mt-2">{{ $product->description }}</p>
            <p class="text-lg font-bold text-green-600 mt-4">${{ $product->price }}</p>
            <p class="text-lg font-bold text-black-600 mt-4">Quantity : {{ session('cart')[$product->id] }}</p>
            <a class="mt-4 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition cursor-pointer" href="/cart/remove/{{ $product->id }}">Remove</a>
        </div>
        @endforeach
    </div>
</x-skeleton>
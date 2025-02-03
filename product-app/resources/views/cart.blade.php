<x-layout title="Cart">
    <div class="mt-20">
        <x-title>{{ __('messages.cart_title') }}</x-title>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 px-4">
            @foreach($products as $product)
                <div class="border border-gray-300 rounded-lg shadow-lg bg-white p-4 flex flex-col items-center text-center justify-between">
                    <div class="">
                        <img class="max-h-70 rounded-lg" src="{{ getImageUrl($product) }}" alt="Product Image">
                    </div>
                    <h2 class="text-lg font-semibold text-gray-800">{{ $product->title }}</h2>
                    <p class="text-sm text-gray-600 mt-2">{{ $product->description }}</p>
                    <p class="text-lg font-bold text-green-600 mt-4">${{ $product->price }}</p>
                    <p class="text-lg font-bold text-black-600 mt-4">{{ __('messages.quantity') }} {{ session('cart')[$product->id] }}</p>
                    <a class="mt-4 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition cursor-pointer" href="{{ route('cart.remove', $product->id) }}">{{ __('messages.remove') }}</a>
                </div>
            @endforeach
        </div>

        <div class="bg-slate-100 p-8 rounded-2xl shadow-lg w-96 my-20 mx-auto">

            <h2 class="text-slate-900 text-2xl font-semibold text-center mb-6">{{ __('messages.checkout') }}</h2>

            @if ($errors->has('empty'))
                <div class="text-red-500 bg-red-200 p-3 rounded-lg">
                    {{ $errors->first('empty') }}
                </div>
            @endif
            <form class="space-y-4" method="POST" action="{{ route('orders.store') }}">
                @csrf

                <div>
                    <label class="text-slate-900 block mb-1" for="name">{{ __('messages.name') }}</label>
                    <input type="text" id="name"
                        class="w-full p-3 rounded-lg bg-slate-400 text-slate-100 focus:outline-none focus:ring-2 focus:ring-slate-500"
                        placeholder="{{ __('messages.enter_name') }}"
                        name="name"
                        value="{{ old('name') }}">

                    @error('name')
                        <p class="text-red-500">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div>
                    <label class="text-slate-900 block mb-1" for="email">{{ __('messages.email') }}</label>
                    <input type="text" id="email"
                        class="w-full p-3 rounded-lg bg-slate-400 text-slate-100 focus:outline-none focus:ring-2 focus:ring-slate-500"
                        placeholder="{{ __('messages.enter_email') }}"
                        name="email">

                    @error('email')
                        <p class="text-red-500">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <button type="submit" class="w-full bg-slate-600 cursor-pointer hover:bg-slate-500 text-slate-100 py-3 rounded-lg font-semibold transition">{{ __('messages.done') }}</button>
            </form>
        </div>
    </div>
</x-layout>
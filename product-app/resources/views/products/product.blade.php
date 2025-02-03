<x-layout>
    <div class="mt-30">
        <div class="bg-slate-100 p-8 rounded-2xl shadow-lg w-200 my-5 mx-auto">
            <strong>
                <h1 class="text-center text-3xl mb-5">{{ $edit ? __('messages.edit_product') . ' #' . $product->id : __('messages.add')}}</h1>
            </strong>

            @if ($errors->has('empty'))
            <div class="text-red-500 bg-red-200 p-3 rounded-lg">
                {{ $errors->first('empty') }}
            </div>
            @endif

            <form class="space-y-4" method="POST" action="{{ $edit ? route('products.update', $product) : route('products.store') }}" enctype="multipart/form-data">
                @csrf

                @method($edit ? 'PATCH' : 'POST')

                @if ($edit && $product->image_filename)
                    <div class="flex justify-center">
                        <img class="max-w-50 rounded-lg" src="{{getImageUrl($product)}}" alt="Product image">
                    </div>
                @endif

                <div>
                    <label class="text-slate-900 block mb-1" for="title">{{ __('messages.title') }}</label>
                    <input type="text" id="title"
                        class="w-full p-3 rounded-lg bg-slate-400 text-slate-100 focus:outline-none focus:ring-2 focus:ring-slate-500"
                        placeholder="{{ __('messages.enter_title') }}"
                        name="title"
                        value="{{ $edit ? $product->title : '' }}">

                    @error('title')
                        <p class="text-red-500">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div>
                    <label class="text-slate-900 block mb-1" for="email">{{ __('messages.email') }}</label>
                    <textarea type="text" id="description"
                        class="resize-none w-full p-3 rounded-lg bg-slate-400 text-slate-100 focus:outline-none focus:ring-2 focus:ring-slate-500"
                        placeholder="{{ __('messages.enter_description') }}"
                        name="description" rows="7">{{ $edit ? $product->description : '' }}</textarea>

                    @error('description')
                        <p class="text-red-500">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div>
                    <label class="text-slate-900 block mb-1" for="price">{{ __('messages.price') }}</label>
                    <input type="text" id="price"
                        class="w-full p-3 rounded-lg bg-slate-400 text-slate-100 focus:outline-none focus:ring-2 focus:ring-slate-500"
                        placeholder="{{ __('messages.enter_price') }}"
                        name="price"
                        value="{{ $edit ? $product->price : '' }}">

                    @error('price')
                        <p class="text-red-500">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div>
                    <label class="text-slate-900 block mb-1" for="image">{{ __('messages.image') }}</label>
                    <input class="p-3 border cursor-pointer border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" type="file" name="image">

                    @error('image')
                        <p class="text-red-500">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
                <button type="submit" class="w-full bg-slate-600 cursor-pointer hover:bg-slate-500 text-slate-100 py-3 rounded-lg font-semibold transition">
                    {{ __('messages.publish') }}
                </button>
            </form>
        </div>
    </div>
</x-layout>
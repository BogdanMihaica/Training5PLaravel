<div class="z-50 w-full h-15 bg-slate-500 fixed top-0 flex justify-between items-center px-5">
    <div class="flex gap-5">
        <x-navlink href="{{ route('products.index') }}"
            class="{{ request()->route()->getName() == 'products.index' ? 'bg-slate-700' : 'bg-slate-600' }}">{{ __('messages.home') }}</x-navlink>
        <x-navlink href="{{ route('cart.index') }}"
            class="{{ request()->route()->getName() == 'cart.index' ? 'bg-slate-700' : 'bg-slate-600' }}">{{ __('messages.cart') }}</x-navlink>

        @if (!session()->has('user'))
            <x-navlink href="{{ route('login') }}"
                class="{{ request()->route()->getName() == 'login' ? 'bg-slate-700' : 'bg-slate-600' }}">{{ __('messages.login') }}</x-navlink>
        @else
            <x-navlink href="{{ route('products.dashboard') }}"
                class="{{ request()->route()->getName() == 'products.dashboard' ? 'bg-slate-700' : 'bg-slate-600' }}">{{ __('messages.products_link') }}</x-navlink>
            <x-navlink href="{{ route('orders.index') }}"
                class="{{ request()->route()->getName() == 'orders.index' ? 'bg-slate-700' : 'bg-slate-600' }}">{{ __('messages.orders_link') }}</x-navlink>
            <x-navlink href="{{ route('products.create') }}"
                class="{{ request()->route()->getName() == 'products.create' ? 'bg-slate-700' : 'bg-slate-600' }}">{{ __('messages.publish') }}</x-navlink>
            <x-navlink href="{{ route('logout') }}" class="bg-black">{{ __('messages.logout') }}</x-navlink>
        @endif
    </div>

    <div class="flex gap-4">
        <a href="?lang=ro" class="text-white px-4 py-2 bg-slate-600 rounded-lg hover:bg-slate-700 transition">RO</a>
        <a href="?lang=en" class="text-white px-4 py-2 bg-slate-600 rounded-lg hover:bg-slate-700 transition">EN</a>
    </div>
</div>

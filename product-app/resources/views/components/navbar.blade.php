<div class="w-full h-15 bg-slate-500 fixed top-0 flex justify-start items-center gap-5">
    <x-navlink href="/" class="{{ request()->is('/') ? 'bg-slate-700' : 'bg-slate-600' }}">Home</x-navlink>
    <x-navlink href="/cart" class="{{ request()->is('cart') ? 'bg-slate-700' : 'bg-slate-600' }}">Cart</x-navlink>
    <x-navlink href="/login" class="{{ request()->is('login') ? 'bg-slate-700' : 'bg-slate-600' }}">Login</x-navlink>
</div>
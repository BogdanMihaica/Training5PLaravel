<x-layout title="Login">
    <div class="flex justify-center items-center min-h-screen bg-slate-900">
        <div class="bg-slate-800 p-8 rounded-2xl shadow-lg w-96">

            <h2 class="text-slate-100 text-2xl font-semibold text-center mb-6">{{ __('messages.login_title') }}</h2>

            @if ($errors->has('no-match'))
                <div class="text-red-500 bg-red-200 p-3 rounded-lg">
                    {{ $errors->first('no-match') }}
                </div>
            @endif

            <form class="space-y-4" method="POST" action="{{ route('login') }}">
                @csrf

                <p class="text-red-500">
                    @error('match-error')
                        {{ __('messages.match_error') }}
                    @enderror
                </p>

                <div>
                    <label class="text-slate-300 block mb-1" for="username">{{ __('messages.username') }}</label>
                    <input type="text" id="username"
                        class="w-full p-3 rounded-lg bg-slate-700 text-slate-100 focus:outline-none focus:ring-2 focus:ring-slate-500"
                        placeholder="{{ __('messages.enter_username') }}" name="username" value="{{ old('username') }}">
                    <p class="text-red-500">
                        @error('username')
                            {{ $message }}
                        @enderror
                    </p>
                </div>

                <div>
                    <label class="text-slate-300 block mb-1" for="password">{{ __('messages.password') }}</label>
                    <input type="password" id="password"
                        class="w-full p-3 rounded-lg bg-slate-700 text-slate-100 focus:outline-none focus:ring-2 focus:ring-slate-500"
                        placeholder="{{ __('messages.enter_password') }}" name="password">

                    @error('password')
                        <p class="text-red-500">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <button type="submit"
                    class="w-full bg-slate-600 cursor-pointer hover:bg-slate-500 text-slate-100 py-3 rounded-lg font-semibold transition">{{ __('messages.login_button') }}</button>
            </form>
        </div>
    </div>
</x-layout>

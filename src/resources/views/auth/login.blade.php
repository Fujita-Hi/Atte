<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="メールアドレス"/>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" 
                            placeholder="パスワード"/>

            <x-input-error :messages="$errors->get('password')" class="mt-2" />

        </div>

        <div class="flex items-center justify-center mt-4">
            <x-primary-button>
                {{ __('ログイン') }}
            </x-primary-button>
        </div>
        
        <div class="flex items-center justify-center mt-4">
            <p>アカウントをお持ちでない方はこちらから</p>
        </div>

        <div class="flex items-center justify-center">
            <a href="/register">会員登録</a>
        </div>
        
    </form>
</x-guest-layout>

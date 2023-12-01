<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('メール認証ができていません。送られたメールから認証をお願いします。') }}
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-green-600">
            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
        </div>
    @endif

    <div class="mt-4 flex items-center justify-between">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <div　class="mt-4 flex items-center justify-between">
                <x-primary-button>
                    {{ __('メール再送信') }}
                </x-primary-button>

        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="underline　mt-4 flex items-center justify-between">
                {{ __('ログアウト') }}
            </button>
        </form>
    </div>
</x-guest-layout>

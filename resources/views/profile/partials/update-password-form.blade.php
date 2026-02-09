<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <label for="update_password_current_password" class="text-sm font-medium text-gray-700">{{ __('Current Password') }}</label>
            <input id="update_password_current_password" name="current_password" type="password" class="mt-1 block w-full px-3 py-2 border rounded" autocomplete="current-password" />
            @if($errors->updatePassword && $errors->updatePassword->has('current_password'))
                <p class="text-sm text-red-600 mt-1">{{ $errors->updatePassword->first('current_password') }}</p>
            @endif
        </div>

        <div>
            <label for="update_password_password" class="text-sm font-medium text-gray-700">{{ __('New Password') }}</label>
            <input id="update_password_password" name="password" type="password" class="mt-1 block w-full px-3 py-2 border rounded" autocomplete="new-password" />
            @if($errors->updatePassword && $errors->updatePassword->has('password'))
                <p class="text-sm text-red-600 mt-1">{{ $errors->updatePassword->first('password') }}</p>
            @endif
        </div>

        <div>
            <label for="update_password_password_confirmation" class="text-sm font-medium text-gray-700">{{ __('Confirm Password') }}</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full px-3 py-2 border rounded" autocomplete="new-password" />
            @if($errors->updatePassword && $errors->updatePassword->has('password_confirmation'))
                <p class="text-sm text-red-600 mt-1">{{ $errors->updatePassword->first('password_confirmation') }}</p>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded">{{ __('Save') }}</button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>

<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Delete Account') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')" class="px-4 py-2 bg-red-600 text-white rounded">{{ __('Delete Account') }}</button>

    <div x-data="{ open: {{ $errors->userDeletion->isNotEmpty() ? 'true' : 'false' }} }" x-on:open-modal.window="if($event.detail === 'confirm-user-deletion') open = true">
        <div x-show="open" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 p-4">
            <div class="bg-white rounded-lg max-w-lg w-full p-6">
                <form method="post" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('delete')

                    <h2 class="text-lg font-medium text-gray-900">
                        {{ __('Are you sure you want to delete your account?') }}
                    </h2>

                    <p class="mt-1 text-sm text-gray-600">
                        {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                    </p>

                    <div class="mt-6">
                        <label for="password" class="sr-only">{{ __('Password') }}</label>
                        <input id="password" name="password" type="password" class="mt-1 block w-full px-3 py-2 border rounded" placeholder="{{ __('Password') }}" />
                        @if($errors->userDeletion && $errors->userDeletion->has('password'))
                            <p class="text-sm text-red-600 mt-1">{{ $errors->userDeletion->first('password') }}</p>
                        @endif
                    </div>

                    <div class="mt-6 flex justify-end">
                        <button type="button" x-on:click="open=false" class="px-4 py-2 border rounded">{{ __('Cancel') }}</button>
                        <button type="submit" class="ms-3 px-4 py-2 bg-red-600 text-white rounded">{{ __('Delete Account') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

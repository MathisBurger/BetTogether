<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('messages.createCommunity') }}
        </h2>
    </x-slot>
    <div class="py-12">
      <x-card>
          <x-validation-errors class="mb-4" />
          <form method="POST" action="{{ route('create-community-action') }}">
              @csrf

              <div>
                  <x-label for="name" value="{{ __('messages.name') }}" />
                  <x-input id="name" class="block mt-1 w-full" type="text" name="name" required autofocus autocomplete="name" />
              </div>

              <div class="mt-4">
                  <x-label value="{{ __('messages.joinPolicy') }}" />
                  <x-select name="joinPolicy">
                      <option value="open">{{__('messages.open')}}</option>
                      <option value="closed">{{__('messages.closed')}}</option>
                  </x-select>
              </div>

              <div class="mt-4">
                  <x-label value="{{ __('messages.betCreationPolicy') }}" />
                  <x-select name="betCreationPolicy">
                      <option value="admin">{{__('messages.creationPolicyAdminOnly')}}</option>
                      <option value="creators">{{__('messages.creationPolicyCreatorsOnly')}}</option>
                      <option value="everyone">{{__('messages.creationPolicyEveryone')}}</option>
                  </x-select>
              </div>

              <div class="flex items-center justify-end mt-4">
                  <x-button class="ms-4">
                      {{ __('messages.create') }}
                  </x-button>
              </div>
          </form>
      </x-card>
    </div>
</x-app-layout>
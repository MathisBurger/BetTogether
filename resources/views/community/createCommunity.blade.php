<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create community') }}
        </h2>
    </x-slot>
    <div class="py-12">
      <x-card>
          <x-validation-errors class="mb-4" />
          <form method="POST" action="{{ route('register') }}">
              @csrf

              <div>
                  <x-label for="name" value="{{ __('Name') }}" />
                  <x-input id="name" class="block mt-1 w-full" type="text" name="name" required autofocus autocomplete="name" />
              </div>

              <div class="mt-4">
                  <x-label value="{{ __('Join policy') }}" />
                  <x-select>
                      <option value="open">Open</option>
                      <option value="request">Request</option>
                      <option value="closed">Closed</option>
                  </x-select>
              </div>

              <div class="mt-4">
                  <x-label value="{{ __('Bet creation policy') }}" />
                  <x-select>
                      <option value="admin">Admin only</option>
                      <option value="creators">Creators only</option>
                      <option value="everyone">Everyone</option>
                  </x-select>
              </div>

              <div class="flex items-center justify-end mt-4">
                  <x-button class="ms-4">
                      {{ __('Create') }}
                  </x-button>
              </div>
          </form>
      </x-card>
    </div>
</x-app-layout>
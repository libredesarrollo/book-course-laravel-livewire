<div>
    <div class="flex" x-data="{ active: $wire.entangle('step') }" class="flex flex-col max-w-sm mx-auto">
        <div class="flex mx-auto flex-col sm:flex-row mb-5">
            <div class="step" :class="{ 'active': parseInt(active) == 1 }">
                {{ __('STEP 1') }}
            </div>
            <div class="step" :class="{ 'active': parseInt(active) == 2 }">
                {{ __('STEP 2') }}
            </div>
            <div class="step" :class="{ 'active': parseInt(active) == 3 }">
                {{ __('STEP 3') }}
            </div>

            {{-- <div x-text="active"></div>
            <div x-text="$wire.step"></div>
            <div x-text="$wire.get('step')"></div>
            {{ $step }} --}}

        </div>
    </div>
    @if ($step == 1)
        <form wire:submit.prevent='submit'>
            <x-label>{{ __('Subject') }}</x-label>
            <x-input-error for='subject' />
            <x-input type='text' wire:model='subject' />

            <x-label>{{ __('Type') }}</x-label>
            <x-input-error for='type' />
            <select wire:model='type'>
                <option value=""></option>
                <option value="person">{{ __('Person') }}</option>
                <option value="company">{{ __('Company') }}</option>
            </select>

            <x-label>{{ __('Message') }}</x-label>
            <x-input-error for='message' />
            <textarea wire:model='message'></textarea>

            <div class="flex mt-5 gap-3">
                <x-button type='submit'>{{ __('Send') }}</x-button>
            </div>
        </form>
    @elseif ($step == 2)
        @livewire('contact.company', ['parentId' => $pk])
    @elseif ($step == 2.5)
        @livewire('contact.person', ['parentId' => $pk])
    @elseif ($step == 3)
        @livewire('contact.detail', ['parentId' => $pk])
    @else
        END
    @endif
    {{-- @livewire('contact.person') --}}
</div>

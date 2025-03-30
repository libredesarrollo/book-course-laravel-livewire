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
        </div>
    </div>
    <div>
        @if ($step == 1)
            <form wire:submit.prevent='submit'>
                <flux:label>{{ __('Subject') }}</flux:label>
                <flux:error name='subject' />
                <flux:input type='text' wire:model='subject'  />

                <flux:label>{{ __('Type') }}</flux:label>
                <flux:error name='type' />
                <flux:select wire:model='type'>
                    <option value=""></option>
                    <option value="person">{{ __('Person') }}</option>
                    <option value="company">{{ __('Company') }}</option>
                </flux:select>

                <flux:label>{{ __('Message') }}</flux:label>
                <flux:error name='message' />
                <flux:textarea wire:model='message'></flux:textarea>

                <div class="flex mt-5 gap-3">
                    <flux:button variant='primary' type='submit'>{{ __('Send') }}</flux:button>
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
    </div>
</div>

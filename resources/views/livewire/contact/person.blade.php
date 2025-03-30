<div>
    <form wire:submit.prevent='submit' class="flex flex-col max-w-sm mx-auto">
        <flux:label>{{ __('Name') }}</flux:label>
        <flux:error name='name' />
        <x-input type='text' wire:model='name' />

        <flux:label>{{ __('Surname') }}</flux:label>
        <flux:error name='surname' />
        <x-input type='text' wire:model='surname' />

        <flux:label>{{ __('Choices') }}</flux:label>
        <flux:error name='choice' />
        <flux:select wire:model='choices'>
            <option value=""></option>
            <option value="advert">{{ __('Advert') }}</option>
            <option value="post">{{ __('Post') }}</option>
            <option value="course">{{ __('Course') }}</option>
            <option value="movie">{{ __('Movie') }}</option>
            <option value="other">{{ __('Other') }}</option>
        </flux:select>

        <flux:label>{{ __('Other') }}</flux:label>
        <flux:error name='other' />
        <flux:textarea variant='primary' wire:model='other'></flux:textarea>

        <div class="flex mt-5 gap-3">
            <x-button variant='primary' type='submit'>{{ __('Send') }}</x-button>
            <x-button wire:click="back()">Back</x-button>
        </div>
    </form>
</div>

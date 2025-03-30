<div>
    <form wire:submit.prevent='submit' class="flex flex-col max-w-sm mx-auto">
        <flux:label>{{ __('Name') }}</flux:label>
        <flux:error name='name' />
        <flux:input type='text' wire:model='name' />

        <flux:label>{{ __('Email') }}</flux:label>
        <flux:error name='email' />
        <flux:input type='email' wire:model='email' />

        <flux:label>{{ __('Identification') }}</flux:label>
        <flux:error name='identification' />
        <flux:input type='text' wire:model='identification' />

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

        <flux:label>{{ __('Extra') }}</flux:label>
        <flux:error name='extra' />
        <flux:textarea wire:model='extra'></flux:textarea>

        <div class="flex mt-5 gap-3">
            <flux:button variant='primary' type='submit'>{{ __('Send') }}</flux:button>
            <flux:button wire:click="back()">Back</flux:button>
        </div>
    </form>
</div>
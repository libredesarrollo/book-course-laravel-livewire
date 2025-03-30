<div>
    <form wire:submit.prevent='submit' class="flex flex-col max-w-sm mx-auto">
        <flux:label>{{ __('Extra') }}</flux:label>
        <flux:error name='extra' />
        <flux:textarea wire:model='extra'></flux:textarea>
        
        <div class="flex mt-5 gap-3">
            <x-button variant='primary' type='submit'>{{ __('Send') }}</x-button>
            <x-button wire:click="back()">Back</x-button>
        </div>
    </form>
</div>

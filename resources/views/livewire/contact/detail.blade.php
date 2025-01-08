<div>
    <form wire:submit.prevent='submit' class="flex flex-col max-w-sm mx-auto">
        <x-label>{{ __('Extra') }}</x-label>
        <x-input-error for='extra' />
        <textarea wire:model='extra'></textarea>
        <div class="flex mt-5 gap-3">
            <x-button type='submit'>{{ __('Send') }}</x-button>
            <x-secondary-button wire:click="back()">Back</x-secondary-button>
        </div>
    </form>
</div>

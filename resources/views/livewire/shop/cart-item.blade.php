<div>
    <div class="box mb-3">
        @if ($item)
            <div class="flex flex-row gap-2 items-center item_{{ $item->id }}" >
                <flux:input wire:keydown.enter='add({{ $item }},$wire.count)' wire:model='count' class="!w-20"
                    type="number"/>
                <flux:label>{{ $item->title }}</flux:label>
            </div>
        @endif
    </div>
</div>

<div>
    <div class="box mb-3">
        @if ($item)
            <p>
                <input wire:keydown.enter='add({{ $item }},$wire.count)' wire:model='count' class="w-20"
                    type="number">
                {{ $item->title }}
            </p>
        @endif
    </div>
</div>

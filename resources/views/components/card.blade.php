<div {{ $attributes->merge([ 'class' => 'w-full sm:max-w-4xl mt-6 shadow-md' ]) }}>
    <div class="text-3xl text-center text-gray-600">
        {{ $title }}
    </div>
    <div class="px-6 py-4">
        {{ $slot }}
    </div>
</div>
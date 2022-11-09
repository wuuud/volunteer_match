@props(['message'])

@if ($message)
    <div class="bg-orange-100 border-orange-500 text-orange-700 border-l-4 p-4 my-2">
        {{ $message }}
    </div>
@endif

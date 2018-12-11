@if ($item)
    @if ($item->avatar_url)
        <img src="{{ $item->avatar_url }}" class="cell-avatar"/>
    @endif
    {{ $item->name }}
@endif

@props(['span', 'search' => null, 'has_search' => 1])

<tr>
    <td {{ $attributes->merge(['class' => 'td text-center']) }} colspan="{{ $span }}">
        @if ($search)
            <span>Sin registros encontrados para <b>{{ $search }}</b></span>
        @else
            <span>Sin registros encontrados</span>
        @endif
    </td>
</tr>

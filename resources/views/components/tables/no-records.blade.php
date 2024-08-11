@props(['id', 'span', 'search' => null, 'has_search' => 1])

<tr>
    <td {{ $attributes->merge(['class' => 'td text-center']) }} colspan="{{ $span }}">
        <span>Sin registros encontrados
            @if ($search)
                para <b>{{ $search }}</b>
            @endif
        </span>
    </td>
</tr>

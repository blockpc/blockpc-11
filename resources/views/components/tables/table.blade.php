<table {{ $attributes->merge(['class' => 'table']) }}>
    <thead class="thead">
        {{ $thead }}
    </thead>
    <tbody class="tbody">
        {{ $tbody }}
    </tbody>
    <tfoot class="tfoot">
        {{ $tfoot ?? '' }}
    </tfoot>
</table>

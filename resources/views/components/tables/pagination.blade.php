@props(['model', 'view' => 'layouts.pagination'])
<div class="mt-4">
    {{ $model->links($view) }}
</div>

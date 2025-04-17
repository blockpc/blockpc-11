<?php

declare(strict_types=1);

namespace App\Livewire\Permissions;

use App\Models\Permission;
use Blockpc\App\Traits\CustomPaginationTrait;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

final class TablePermissions extends Component
{
    use CustomPaginationTrait;

    protected $listeners = [
        'permissionsUpdated' => '$refresh',
    ];

    public $key_id;

    public function mount()
    {
        $this->authorize('permission list');
    }

    #[Layout('layouts.backend')]
    #[Title('pages.permissions.titles.table')]
    public function render()
    {
        return view('livewire.permissions.table-permissions');
    }

    #[Computed()]
    public function permissions()
    {
        return Permission::query()
            ->when(! current_user()->hasRole('sudo'), function ($query) {
                $query->whereNotIn('key', ['sudo']);
            })
            ->when($this->key_id, function ($query) {
                $query->where('key', $this->key_id);
            })
            ->whereLike(['display_name', 'description'], $this->search)
            ->paginate($this->paginate);
    }

    #[Computed]
    public function claves()
    {
        return Permission::query()
            ->when(! current_user()->hasRole('sudo'), function ($query) {
                $query->whereNotIn('key', ['sudo']);
            })
            ->distinct()
            ->pluck('key', 'key');
    }

    public function update_permission($id)
    {
        $this->dispatch('show', $id)->to(UpdatePermission::class);
    }
}

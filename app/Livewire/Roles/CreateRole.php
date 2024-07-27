<?php

declare(strict_types=1);

namespace App\Livewire\Roles;

use App\Models\Role;
use Blockpc\App\Traits\AlertBrowserEvent;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

final class CreateRole extends Component
{
    use AlertBrowserEvent;

    public $name;

    public $display_name;

    public $description;

    public function mount()
    {
        $this->authorize('role create');
    }

    #[Layout('layouts.backend')]
    #[Title('pages.roles.titles.create')]
    public function render()
    {
        return view('livewire.roles.create-role');
    }

    public function save()
    {
        $this->validate();

        $role = Role::create([
            'name' => $this->name,
            'guard_name' => 'web',
            'display_name' => $this->display_name,
            'description' => $this->description,
        ]);

        // $this->dispatchBrowserEvent('alert', [
        //     'title' => __('roles.titles.create'),
        //     'message' => __('roles.messages.created', ['name' => $role->name]),
        //     'type' => 'success',
        // ]);

        $this->flash('Cargo creado correctamente.', 'success');

        return redirect()->route('roles.table');
    }

    protected function rules()
    {
        return [
            'name' => 'required|string|min:3|max:50|unique:roles,name',
            'display_name' => 'required|string|min:3|max:50',
            'description' => 'nullable|string|max:255',
        ];
    }

    protected function getValidationAttributes()
    {
        return __('pages.roles.attributes.form');
    }
}

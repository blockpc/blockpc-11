<?php

declare(strict_types=1);

namespace Blockpc\App\Livewire\Notifications;

use App\Models\User;
use Livewire\Attributes\Computed;

trait SelectTwoOnlyOneUserTrait
{
    public $search_user;

    public $select_user_name;

    public $select_user_id;

    #[Computed()]
    public function users()
    {
        return User::where('id', '!=', current_user()->id)
            ->when($this->search_user, function ($query) {
                $query->search($this->search_user);
            })
            ->get()
            ->pluck('fullname', 'id');
    }
}

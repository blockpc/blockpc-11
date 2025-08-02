<?php

declare(strict_types=1);

namespace Blockpc\App\Traits;

use Livewire\WithPagination;

trait CustomPaginationTrait
{
    use WithPagination;

    public $search = '';

    public $paginate = 10;

    public $soft_deletes = 0;

    public function clean_search()
    {
        $this->search = '';
        $this->resetPage();
    }

    public function show_deleteds()
    {
        $this->soft_deletes = ! $this->soft_deletes;
        $this->resetPage();
    }
}

<?php

namespace App\Http\Livewire\User;

use App\Services\UserService;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search;

    public function render()
    {
        $userService = new UserService();
        return view('livewire.user.index', ['users' => $userService->listUsers($this->search)]);
    }
}

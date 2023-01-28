<?php

namespace App\Services;

use App\Models\User;

class UserService extends Service
{
    public function __construct()
    {
        $this->setModel(new User());
    }

    public function listUsers($search, $paginatePages = 10)
    {
        $users = User::query();
        if ($search) {
            $users->where('name', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%');
        }
        $users->orderBy('created_at', 'desc');
        return $users->paginate($paginatePages);
    }
}
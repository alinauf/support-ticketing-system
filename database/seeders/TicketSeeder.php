<?php

namespace Database\Seeders;

use App\Models\Ticket;
use App\Models\TicketReply;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminUser = User::where('is_admin', true)->first();
        Ticket::factory(1000)
            ->state(new Sequence(
                ['is_open' => true],
                ['is_open' => false, 'closed_by' => $adminUser->id],
            ))
            ->create();
        TicketReply::factory(1000)->create();
    }
}

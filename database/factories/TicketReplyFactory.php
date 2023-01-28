<?php

namespace Database\Factories;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TicketReply>
 */
class TicketReplyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $ticket = Ticket::all()->random();
        $adminUser = User::where('is_admin', true)->first();
        return [
            'ticket_id' => $ticket->id,
            'user_id' => $this->faker->boolean(50) ? $ticket->user_id : $adminUser->id,
            'reply' => fake()->paragraph(),
        ];
    }
}

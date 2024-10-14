<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Message>
 */
class MessageFactory extends Factory
{
    public function definition(): array
    {
        if (\App\Models\User::count() === 0 || \App\Models\Group::count() === 0) {
            throw new \Exception('User and Group Must have records in database for this to work');
        }

        $sender_id = $this->faker->randomElement([0, 1]);

        if ($sender_id === 0) {
            // if there is no sender_id (0) then choose random user as sender and user 1 as receiver
            $sender_id = $this->faker->randomElement(
                \App\Models\User::where('id', '!=', 1)
                    ->pluck('id')
                    ->toArray()
            );

            $receiver_id = 1;
        } else {
            // choose user 1 as sender and a random user from database as receiver
            $receiver_id = $this->faker->randomElement(
                \App\Models\User::pluck('id')
                    ->toArray()
            );
        }

        $group_id = null;

        // Add a 50 percent chance that the message is sent to a random group
        if ($this->faker->boolean(50)) {
            $group_id = $this->faker->randomElement(
                \App\Models\Group::pluck('id')->toArray()
            );

            // the sender of the message must be from that groups users
            $group = \App\Models\Group::find($group_id);
            $sender_id = $this->faker->randomElement(
                $group->users->pluck('id')->toArray()
            );

            // message is for group, so there is no need for a receiver
            $receiver_id = null;
        }

        return [
            'sender_id' => $sender_id,
            'receiver_id' => $receiver_id,
            'group_id' => $group_id,
            'message' => $this->faker->realText(200),
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}

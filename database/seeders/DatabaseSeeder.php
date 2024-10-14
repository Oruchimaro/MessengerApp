<?php

namespace Database\Seeders;

use App\Models\Conversation;
use App\Models\Group;
use App\Models\Message;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // create admin user
        User::factory()->create([
            'name' => 'admin user',
            'email' => 'am@am.am',
            'password' => bcrypt('password'),
            'is_admin' => true,
            'email_verified_at' => now(),
        ]);

        // create a regular user
        User::factory()->create([
            'name' => 'John Doe',
            'email' => 'john@doe.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
        ]);

        // add another 10 users
        User::factory(10)->create();

        // create 5 groups and add 2 to 5 users and the admin inside that group
        for ($ii = 0; $ii < 5; $ii++) {
            $group = Group::factory()->create([
                'owner_id' => 1,
            ]);

            $users = User::inRandomOrder()->limit(rand(2, 5))->pluck('id')->toArray();
            $group->users()->attach(array_unique([1, ...$users]));
        }

        // create 1000 messages
        Message::factory(1000)->create();

        // create conversations from messages that are not in groups
        $messagesNotInGroup = Message::whereNull('group_id')
            ->orderBy('created_at')
            ->get();

        $conversations = $messagesNotInGroup->groupBy(function ($message) {
            return collect([$message->sender_id, $message->receiver_id])
                ->sort()
                ->implode('_');
        })->map(function ($groupedMessages) {
            return [
                'user_id1' => $groupedMessages->first()->sender_id,
                'user_id2' => $groupedMessages->first()->receiver_id,
                'last_message_id' => $groupedMessages->last()->id,
                'created_at' => new Carbon,
                'updated_at' => new Carbon,
            ];
        })->values();

        Conversation::insertOrIgnore($conversations->toArray());
    }
}

// messages :[sender, receiver]
// [1,2]
// [1,3]
// [2,1]
// [1,2]

// conversation 1
//  1 - 2
// conversation 2
//  1 - 3

// [1,2] ,[2,1] ,[1,2]  are in the same conversation and [1,3] is another

// so we group them together to create the conversation

// [
//     1-2 => [
//         [1,2],
//         [2,1],
//         [1,2]
//     ],
//     1-3 => [
//         [1,3]
//     ]
// ]

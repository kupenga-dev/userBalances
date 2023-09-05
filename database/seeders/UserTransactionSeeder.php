<?php

namespace Database\Seeders;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserTransactionSeeder extends Seeder
{
    public function run()
    {
        // Создайте 2 пользователя
        $users = User::factory(2)->create();

        // Создайте по 5 транзакций для каждого пользователя
        foreach ($users as $user) {
            Transaction::factory(5)->create(['user_id' => $user->id]);
        }
    }
}

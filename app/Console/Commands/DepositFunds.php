<?php

namespace App\Console\Commands;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Console\Command;

class DepositFunds extends Command
{
    protected $signature = 'balance:deposit {user_id} {amount}';

    protected $description = 'Deposit funds to a user\'s balance';

    public function handle()
    {
        $user = User::findOrFail($this->argument('user_id'));
        $amount = $this->argument('amount');

        // Создайте новую запись транзакции для зачисления
        Transaction::create([
            'user_id' => $user->id,
            'amount' => $amount,
            'type' => 'deposit',
        ]);

        // Увеличьте баланс пользователя
        $user->balance += $amount;
        $user->save();

        $this->info('Funds deposited successfully.');
    }
}

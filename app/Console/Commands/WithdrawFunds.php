<?php

namespace App\Console\Commands;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Console\Command;

class WithdrawFunds extends Command
{
    protected $signature = 'balance:withdraw {user_id} {amount}';

    protected $description = 'Withdraw funds from a user\'s balance';

    public function handle(): void
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
        $user->balance -= $amount;
        $user->save();

        $this->info('Funds withdraw successfully.');
    }
}

<?php

namespace App\Console\Commands;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Console\Command;

class ShowTransactions extends Command
{
    protected $signature = 'transactions:show {user_id}';

    protected $description = 'Show transactions for a user';

    public function handle()
    {
        $user = User::findOrFail($this->argument('user_id'));

        $transactions = Transaction::where('user_id', $user->id)->get();

        foreach ($transactions as $transaction) {
            $this->line("Transaction ID: {$transaction->id}");
            $this->line("Amount: {$transaction->amount}");
            $this->line("Type: {$transaction->type}");
            $this->line("Created at: {$transaction->created_at}");
            $this->line('------------------------');
        }
    }
}

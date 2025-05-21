<?php

namespace App\Livewire\Account\MyOrders;

use Livewire\Component;
use App\Models\Transaction;

class Index extends Component
{
    public function render()
    {
        //get transactions
        $transactions = Transaction::query()
            ->where('customer_id', auth()->guard('customer')->user()->id)
            ->latest()
            ->simplePaginate(3);

        return view('livewire.account.my-orders.index', compact('transactions'));
    }
}
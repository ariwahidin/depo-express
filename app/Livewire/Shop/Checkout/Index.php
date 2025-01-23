<?php

namespace App\Livewire\Shop\Checkout;

use Exception;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    public $snap_token;
    public $transaction_id;
    public function render()
    {
        return view('livewire.shop.checkout.index');
    }

    public function createTransaction()
    {
        $transaction = \App\Models\Transaction::create([
            'user_id' => Auth::id(),
            'product_id' => 1,
            'amount' => 10000,
            'status' => 'pending',
            'snap_token' => null,
            'created_by' => Auth::id(),
        ]);
        $this->transaction_id = $transaction->id;
        $this->generateSnapToken($this->transaction_id);
    }

    public function generateSnapToken($transaction_id)
    {
        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = false;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;

        $params = array(
            'transaction_details' => array(
                'order_id' => rand(),
                'gross_amount' => 10000,
            ),
            'customer_details' => array(
                'first_name' => Auth::user()->name,
                'email' => Auth::user()->email
            )
        );

        $snapToken = \Midtrans\Snap::getSnapToken($params);
        $transaction = \App\Models\Transaction::findOrFail($transaction_id);
        $transaction->snap_token = $snapToken;
        $transaction->save();

        $this->snap_token = $snapToken;
        $this->dispatch('pay', ['snap_token' => $snapToken, 'transaction_id' => $transaction_id]);
    }

    #[\Livewire\Attributes\On('successPayment')]
    public function onSuccess($transaction_id)
    {
        $transaction = \App\Models\Transaction::findOrFail($transaction_id);
        $transaction->status = 'success';
        $transaction->save();
    }
}

<?php

namespace App\Livewire\GoodReceive;

use App\Models\Stock;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class Block extends Component
{
    public $receipts;

    #[\Livewire\Attributes\On('reloadReceipt')]
    public function mount()
    {
        $this->receipts = \App\Models\ReceiptDetail::where('delete_status', 'no')
            ->where('status', 'open')
            ->orderByDesc('created_at')
            ->get();
    }


    public function confirm()
    {
        try {
            DB::beginTransaction();

            // Ambil data dengan locking (FOR UPDATE)
            $open_items = \App\Models\ReceiptDetail::where('delete_status', 'no')
                ->where('status', 'open')
                ->where('created_by', Auth::id())
                ->orderByDesc('created_at')
                ->lockForUpdate()
                ->get();

            if ($open_items->isEmpty()) {
                DB::rollBack(); // Tidak ada data, batalkan transaksi
                $this->dispatch('showErrorToast', message: 'No open items found');
                return;
            }

            // Proses data
            foreach ($open_items as $item) {
                $item->status = 'close';
                $item->save();

                \App\Models\Stock::create([
                    'receipt_detail_id' => $item->id,
                    'supplier_id' => $item->supplier_id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'created_by' => Auth::id(),
                ]);
            }

            DB::commit();

            $this->dispatch('reloadReceipt');
            $this->dispatch('showSuccessToast', message: 'All open items received successfully');
        } catch (\Throwable $th) {
            DB::rollBack();

            Log::error('Error in confirm method with locking', [
                'message' => $th->getMessage(),
                'user_id' => Auth::id(),
            ]);

            $this->dispatch('showErrorToast', message: 'Failed to receive all open items. Please try again.');
        }
    }

    
    public function render()
    {
        return view('livewire.good-receive.block');
    }
}

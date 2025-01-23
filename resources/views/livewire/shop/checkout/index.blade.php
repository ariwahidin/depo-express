<div>
    <p>Ini adalah halaman checkout</p>
    <!-- <form> -->
        <input type="text" wire:model="transaction_id">
        <input type="text" wire:model="snap_token">
        <button id="pay-button" wire:click="createTransaction">Pay Now</button>
    <!-- </form> -->
    <pre><div id="result-json">JSON result will appear here after payment:<br></div></pre>
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}" data-navigate-track data-navigate-once></script>
    <script type="text/javascript" data-navigate-track data-navigate-once>
        document.addEventListener('pay', function(event){
            console.log(event);
            let snapToken = event.detail[0].snap_token;
            let transaction_id = event.detail[0].transaction_id;
            console.log(snapToken);
            snap.pay(snapToken, {
                // Optional
                onSuccess: function(result) {
                    // console.log(result);
                    /* You may add your own js here, this is just example */
                    // document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                    // Livewire.dispatch('successPayment', {
                    //     transaction_id: transaction_id
                    // });

                    console.log(result);
                },
                // Optional
                onPending: function(result) {
                    /* You may add your own js here, this is just example */
                    // document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                },
                // Optional
                onError: function(result) {
                    /* You may add your own js here, this is just example */
                    // document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                }
            });
        })
    </script>
</div>
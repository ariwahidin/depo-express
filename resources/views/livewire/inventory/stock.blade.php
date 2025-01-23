<div class="card">
    <h5 class="card-header">{{ $title }}</h5>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($stocks as $stock)
                <tr wire:click="$dispatch('showStokDetail', { product_id: {{ $stock->product_id }} })" class="cursor-pointer" >
                    <td>{{ $stock->product_name }}</td>
                    <td>{{ $stock->quantity }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
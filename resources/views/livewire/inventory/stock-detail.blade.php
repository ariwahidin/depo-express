<div class="card">
    <h5 class="card-header">{{ $title }}</h5>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Category</th>
                    <th>Product</th>
                    <th>Quantity</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($stocks as $stock)
                <tr>
                    <td>{{ $stock->category_name }}</td>
                    <td>{{ $stock->product_name }}</td>
                    <td>{{ $stock->quantity }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<table border="1" cellspacing="0" cellpadding="5">
    <thead>
        <tr>
            <th>Code</th>
            <th>Product Name</th>
            <th>Category</th>
            <th>Unit</th>
            <th>Quantity</th>
            <th>Selling Price</th>
            <th>Purchase Price</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($products as $product)
        <tr>
            <td>{{ $product->code }}</td>
            <td>{{ $product->name }}</td>
            <td>{{ $product->category?->name ?? '—' }}</td>
            <td>{{ $product->unit?->name ?? '—' }}</td>
            <td>{{ $product->variants->sum('quantity') }}</td>
            <td>₹{{ number_format($product->variants->min('selling_price'), 2) }}</td>
            <td>₹{{ number_format($product->variants->min('purchase_price'), 2) }}</td>
            <td>{{ $product->status ? 'Active' : 'Inactive' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

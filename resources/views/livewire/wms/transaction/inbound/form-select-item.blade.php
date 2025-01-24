<div>
    <select id="select-item-{{ $index }}" class="form-control-sm mb-1 mt-2 w-100"
        data-index="{{ $index }}"
        required>
        <option value="">Select Item Code</option>
        @foreach ($itemOptions as $option)
        <option value="{{ $option->item_code }}" {{ $itemSelected == $option->item_code ? 'selected' : '' }}>{{ $option->item_code }}</option>
        @endforeach
    </select>
</div>
@script
<script>
    $('#select-item-{{ $index }}').select2();

    $('#select-item-{{ $index }}').on('change', function(e) {
        console.log('change');
        let index = $(this).data('index');
        let value = $(this).val();
        // console.log(index, value);
        $wire.dispatch('updateSelectItem', {
            index: index,
            value: value
        });
    });

    $('#select-item-{{ $index }}').on('select2:open', function(e) {
        e.preventDefault();
        console.log('test');
    });
</script>
@endscript
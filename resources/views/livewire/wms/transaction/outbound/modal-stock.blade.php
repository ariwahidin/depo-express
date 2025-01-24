<div>
    <div class="modal fade" id="modalStock" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Stock for item : {{ $item_code }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table style="font-size: 12px;" class="table table-sm table-nowrap">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Item Code.</th>
                                <th>Item Name</th>
                                <th>Location</th>
                                <th>Qty Avail</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($stocks == null)
                            <tr>
                                <td colspan="6" class="text-center">No data available</td>
                            </tr>
                            @else
                            @php $no = 1; @endphp
                            @foreach($stocks as $stock)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $stock->item_code }}</td>
                                <td>{{ $stock->item_name }}</td>
                                <td>{{ $stock->location }}</td>
                                <td>{{ $stock->total_qty_avail }}</td>
                                <td class="text-center">
                                    <button @click="$dispatch('selectLocation', { index: {{ $index }}, location: '{{ $stock->location }}' })" class="btn btn-sm btn-primary">Select</button>
                                </td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        window.addEventListener('openModalStock', event => {
            $('#modalStock').modal('show');
        });

        window.addEventListener('closeModalStock', event => {
            $('#modalStock').modal('hide');
        });
    </script>
</div>
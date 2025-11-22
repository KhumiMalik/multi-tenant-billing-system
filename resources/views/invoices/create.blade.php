@extends('layouts.app')

@section('content')
<h3>Create Invoice</h3>

<form method="POST" action="{{ route('invoices.store') }}">
  @csrf

  <div class="mb-3">
    <label>Account</label>
    <select name="account_id" class="form-select">
      @foreach($accounts as $id => $name)
        <option value="{{ $id }}">{{ $name }}</option>
      @endforeach
    </select>
  </div>

  <div id="items">
    <div class="item mb-2 border p-2">
      <input name="items[0][description]" placeholder="Description" class="form-control mb-1" />
      <div class="row">
        <div class="col"><input name="items[0][quantity]" value="1" class="form-control" placeholder="Quantity" /></div>
        <div class="col"><input name="items[0][unit_price]" value="0" class="form-control" placeholder="Unit Price" /></div>
      </div>
      <button type="button" class="btn btn-sm btn-danger mt-1 remove-item">Remove</button>
    </div>
  </div>

  <button type="button" id="add-item" class="btn btn-sm btn-outline-primary mb-3">Add Item</button>

  <div class="mb-3">
    <label>Due Date</label>
    <input type="date" name="due_date" class="form-control" />
  </div>

  <div class="mb-3">
    <label>Notes</label>
    <textarea name="notes" class="form-control"></textarea>
  </div>

  <button class="btn btn-primary">Create Invoice</button>
</form>

<script>
let itemIndex = 1; // next index for items
document.getElementById('add-item').addEventListener('click', function(){
    const container = document.getElementById('items');
    const div = document.createElement('div');
    div.classList.add('item','mb-2','border','p-2');
    div.innerHTML = `
      <input name="items[${itemIndex}][description]" placeholder="Description" class="form-control mb-1" />
      <div class="row">
        <div class="col"><input name="items[${itemIndex}][quantity]" value="1" class="form-control" placeholder="Quantity" /></div>
        <div class="col"><input name="items[${itemIndex}][unit_price]" value="0" class="form-control" placeholder="Unit Price" /></div>
      </div>
      <button type="button" class="btn btn-sm btn-danger mt-1 remove-item">Remove</button>
    `;
    container.appendChild(div);
    itemIndex++;
});

// Remove item button
document.getElementById('items').addEventListener('click', function(e){
    if(e.target && e.target.classList.contains('remove-item')){
        e.target.closest('.item').remove();
    }
});
</script>
@endsection

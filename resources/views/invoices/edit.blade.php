@extends('layouts.app')

@section('content')
<h3>Edit Invoice {{ $invoice->number }}</h3>

<form method="POST" action="{{ route('invoices.update', $invoice->id) }}">
  @csrf
  @method('PUT')

  <div class="mb-3">
    <label>Account</label>
    <select name="account_id" class="form-select">
      @foreach($accounts as $id => $name)
        <option value="{{ $id }}" {{ $invoice->account_id == $id ? 'selected' : '' }}>{{ $name }}</option>
      @endforeach
    </select>
  </div>

  <div id="items">
    @foreach($invoice->items as $index => $item)
      <div class="item mb-2 border p-2">
        <input name="items[{{ $index }}][description]" value="{{ $item->description }}" placeholder="Description" class="form-control mb-1" />
        <div class="row">
          <div class="col"><input name="items[{{ $index }}][quantity]" value="{{ $item->quantity }}" class="form-control" placeholder="Quantity" /></div>
          <div class="col"><input name="items[{{ $index }}][unit_price]" value="{{ $item->unit_price }}" class="form-control" placeholder="Unit Price" /></div>
        </div>
        <button type="button" class="btn btn-sm btn-danger mt-1 remove-item">Remove</button>
      </div>
    @endforeach
  </div>

  <button type="button" id="add-item" class="btn btn-sm btn-outline-primary mb-3">Add Item</button>

  <div class="mb-3">
    <label>Due Date</label>
    <input type="date" name="due_date" value="{{ $invoice->due_date?->toDateString() }}" class="form-control" />
  </div>

  <div class="mb-3">
    <label>Notes</label>
    <textarea name="notes" class="form-control">{{ $invoice->notes }}</textarea>
  </div>

  <div class="mb-3">
    <label>Status</label>
    <select name="status" class="form-select">
      <option value="pending" {{ $invoice->status=='pending'?'selected':'' }}>Pending</option>
      <option value="sent" {{ $invoice->status=='sent'?'selected':'' }}>Sent</option>
      <option value="paid" {{ $invoice->status=='paid'?'selected':'' }}>Paid</option>
    </select>
  </div>

  <button class="btn btn-primary">Update Invoice</button>
</form>

<script>
let itemIndex = {{ $invoice->items->count() }};
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

document.getElementById('items').addEventListener('click', function(e){
    if(e.target && e.target.classList.contains('remove-item')){
        e.target.closest('.item').remove();
    }
});
</script>
@endsection

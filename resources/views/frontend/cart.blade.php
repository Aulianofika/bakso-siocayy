@extends('layouts.frontend')
@section('title', 'Keranjang Saya')

@section('content')
<div class="container py-4">
  <h3 class="fw-bold text-success mb-4">
    <i class="bi bi-cart4 me-2"></i> Keranjang Saya
  </h3>

  @if($cartItems->isEmpty())
    <div class="alert alert-info text-center shadow-sm p-4 rounded-3 bg-white border-0">
      <i class="bi bi-basket2 text-muted fs-3 d-block mb-2"></i>
      Keranjang kamu masih kosong 😢<br>
      Yuk, <a href="{{ route('menu') }}" class="text-success fw-semibold text-decoration-none">
        pilih produk
      </a> dulu 💚
    </div>
  @else
    <form action="{{ route('checkout.index') }}" method="GET" id="cartForm">
      @csrf
      <div class="table-responsive shadow-sm rounded-4 bg-white p-2 p-md-3">
        <table class="table align-middle table-hover mb-0">
          <thead class="table-success text-center d-none d-md-table-header-group">
            <tr>
              <th>
                <input type="checkbox" id="select-all" class="form-check-input">
              </th>
              <th>Produk</th>
              <th>Harga</th>
              <th>Jumlah</th>
              <th>Subtotal</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach($cartItems as $item)
              <tr class="text-center align-middle cart-row" data-id="{{ $item->id }}">
                <td class="d-none d-md-table-cell">
                  <input type="checkbox" name="selected_items[]" value="{{ $item->id }}" 
                         class="form-check-input item-checkbox">
                </td>
                <td class="text-start">
                  <div class="d-flex align-items-center">
                    <input type="checkbox" name="selected_items[]" value="{{ $item->id }}" 
                           class="form-check-input item-checkbox d-md-none me-2">
                    <img src="{{ asset('images/products/'.$item->product->image) }}" 
                         alt="{{ $item->product->name }}" 
                         class="rounded me-2 me-md-3 shadow-sm" 
                         style="width: 50px; height: 50px; object-fit: cover;">
                    <div class="flex-grow-1">
                      <strong class="d-block" style="font-size: 0.9rem;">{{ $item->product->name }}</strong>
                      <small class="text-muted d-block d-md-inline">
                        {{ $item->product->category->name ?? 'Tanpa Kategori' }}
                      </small>
                      <div class="d-md-none mt-2">
                        <small class="text-muted d-block">Harga: </small>
                        <span class="price fw-semibold" data-price="{{ $item->product->price_sale }}">
                          Rp {{ number_format($item->product->price_sale, 0, ',', '.') }}
                        </span>
                      </div>
                    </div>
                  </div>
                </td>
                <td class="price d-none d-md-table-cell text-start" data-price="{{ $item->product->price_sale }}">
                  Rp {{ number_format($item->product->price_sale, 0, ',', '.') }}
                </td>
                <td>
                  <div class="d-flex justify-content-center align-items-center gap-2">
                    <button type="button" class="btn btn-sm btn-outline-success quantity-btn decrease">
                      <i class="bi bi-dash"></i>
                    </button>
                    <span class="fw-semibold quantity-text" data-quantity="{{ $item->quantity }}" style="min-width: 30px;">{{ $item->quantity }}</span>
                    <button type="button" class="btn btn-sm btn-outline-success quantity-btn increase">
                      <i class="bi bi-plus"></i>
                    </button>
                  </div>
                </td>
                <td class="text-success fw-semibold subtotal">
                  <div class="d-md-none">
                    <small class="text-muted d-block">Subtotal:</small>
                  </div>
                  Rp {{ number_format($item->product->price_sale * $item->quantity, 0, ',', '.') }}
                </td>
                <td>
                  <form action="{{ route('cart.remove', $item->id) }}" method="POST" 
                        onsubmit="return confirm('Yakin ingin hapus produk ini dari keranjang?')"
                        class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-outline-danger rounded-circle">
                      <i class="bi bi-trash"></i>
                    </button>
                  </form>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      <div class="d-flex justify-content-between align-items-center mt-4 flex-wrap">
        <h5 class="fw-bold text-success mb-0">
          Total Keseluruhan: <span id="grand-total">Rp 0</span>
        </h5>
        <button type="submit" class="btn btn-green btn-lg shadow-sm mt-2 mt-md-0">
          <i class="bi bi-credit-card-2-back me-1"></i> Bayar Produk Terpilih
        </button>
      </div>
    </form>
  @endif
</div>

{{-- Script interaktif real-time --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
  const checkboxes = document.querySelectorAll('.item-checkbox');
  const selectAll = document.getElementById('select-all');
  const grandTotalElement = document.getElementById('grand-total');

  function formatRupiah(number) {
    return 'Rp ' + number.toLocaleString('id-ID');
  }

  // Hitung total keseluruhan produk yang dipilih
  function updateGrandTotal() {
    let total = 0;
    document.querySelectorAll('.item-checkbox:checked').forEach(chk => {
      const row = chk.closest('.cart-row');
      const subtotalText = row.querySelector('.subtotal').textContent.replace(/[^\d]/g, '');
      total += parseInt(subtotalText) || 0;
    });
    grandTotalElement.textContent = formatRupiah(total);
  }

  // Pilih semua checkbox
  selectAll?.addEventListener('change', function () {
    checkboxes.forEach(chk => chk.checked = this.checked);
    updateGrandTotal();
  });

  // Update total saat centang berubah
  checkboxes.forEach(chk => chk.addEventListener('change', updateGrandTotal));

  // Fungsi tambah/kurang jumlah
  document.querySelectorAll('.quantity-btn').forEach(btn => {
    btn.addEventListener('click', function () {
      const row = btn.closest('.cart-row');
      const qtyText = row.querySelector('.quantity-text');
      const price = parseInt(row.querySelector('.price').dataset.price);
      let qty = parseInt(qtyText.dataset.quantity);

      if (btn.classList.contains('increase')) qty++;
      if (btn.classList.contains('decrease') && qty > 1) qty--;

      // Update tampilan jumlah
      qtyText.dataset.quantity = qty;
      qtyText.textContent = qty;

      // Update subtotal
      const subtotal = price * qty;
      row.querySelector('.subtotal').textContent = formatRupiah(subtotal);

      updateGrandTotal();
    });
  });
});
</script>

<style>
.btn-green {
  background: linear-gradient(135deg, #3ca65a, #2f7a52);
  color: #fff;
  border: none;
  border-radius: 10px;
  padding: 10px 18px;
  transition: 0.3s;
}
.btn-green:hover {
  background: linear-gradient(135deg, #2f7a52, #3ca65a);
  transform: translateY(-2px);
  box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
}
.quantity-btn {
  width: 28px;
  height: 28px;
  line-height: 1;
  padding: 0;
}
.subtotal, .price {
  white-space: nowrap;
}
</style>
@endsection

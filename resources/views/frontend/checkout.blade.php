@extends('layouts.frontend')
@section('title', 'Checkout')

@section('content')
<div class="container py-4">
  <h3 class="fw-bold text-success mb-4">
    <i class="bi bi-credit-card me-2"></i> Konfirmasi Pesanan
  </h3>

  @if($cartItems->isEmpty())
    <div class="alert alert-warning text-center shadow-sm p-4 rounded-4 bg-white border-0">
      <i class="bi bi-cart-x fs-2 d-block text-muted mb-2"></i>
      Keranjang kamu masih kosong 😢<br>
      Yuk, <a href="{{ route('menu') }}" class="text-success fw-semibold text-decoration-none">
        pilih produk
      </a> dulu 💚
    </div>
  @else
    <div class="card p-4 border-0 shadow-sm rounded-4 bg-white">
      <!-- RINGKASAN PESANAN -->
      <h5 class="fw-bold mb-4 text-success">
        <i class="bi bi-receipt-cutoff me-2"></i> Ringkasan Pesanan
      </h5>

      <div class="table-responsive mb-3">
        <table class="table table-borderless align-middle">
          <thead class="border-bottom d-none d-md-table-header-group">
            <tr class="text-muted text-center">
              <th class="text-start">Produk</th>
              <th>Jumlah</th>
              <th class="text-end">Subtotal</th>
            </tr>
          </thead>
          <tbody>
            @foreach($cartItems as $item)
              <tr>
                <td class="text-start">
                  <div class="d-flex align-items-center">
                    <img src="{{ asset('images/products/'.$item->product->image) }}" 
                         alt="{{ $item->product->name }}" 
                         class="rounded me-2 me-md-3 shadow-sm" 
                         style="width: 50px; height: 50px; object-fit: cover;">
                    <div class="flex-grow-1">
                      <strong class="d-block">{{ $item->product->name }}</strong>
                      <small class="text-muted d-block d-md-inline">
                        Rp {{ number_format($item->product->price_sale, 0, ',', '.') }}
                      </small>
                      <div class="d-md-none mt-1">
                        <small class="text-muted">Jumlah: </small>
                        <span class="fw-semibold">{{ $item->quantity }}</span>
                        <small class="text-muted ms-2">Subtotal: </small>
                        <span class="text-success fw-semibold">
                          Rp {{ number_format($item->product->price_sale * $item->quantity, 0, ',', '.') }}
                        </span>
                      </div>
                    </div>
                  </div>
                </td>
                <td class="text-center d-none d-md-table-cell">{{ $item->quantity }}</td>
                <td class="text-end text-success fw-semibold d-none d-md-table-cell">
                  Rp {{ number_format($item->product->price_sale * $item->quantity, 0, ',', '.') }}
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      <div class="border-top pt-3 text-end mb-4">
        <h5 class="fw-bold text-success mb-0">
          Total Pembayaran: Rp {{ number_format($total, 0, ',', '.') }}
        </h5>
      </div>

      <!-- FORM DATA PENGIRIMAN DAN PEMBAYARAN -->
      <form action="{{ route('checkout.process') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <h5 class="fw-bold text-success mb-3">
          <i class="bi bi-person-lines-fill me-2"></i> Data Penerima
        </h5>

        <div class="row g-3 mb-4">
          <div class="col-md-6">
            <label class="form-label fw-semibold">Nama Penerima</label>
            <input type="text" name="nama_penerima" class="form-control rounded-3" placeholder="Masukkan nama lengkap" required>
          </div>
          <div class="col-md-6">
            <label class="form-label fw-semibold">Nomor Telepon</label>
            <input type="text" name="no_telepon" class="form-control rounded-3" placeholder="Contoh: 08123456789" required>
          </div>
          <div class="col-12">
            <label class="form-label fw-semibold">Alamat Lengkap</label>
            <textarea name="alamat" class="form-control rounded-3" rows="3" placeholder="Masukkan alamat lengkap pengiriman" required></textarea>
          </div>
          <div class="col-12">
            <label class="form-label fw-semibold">Catatan Tambahan (Opsional)</label>
            <textarea name="catatan" class="form-control rounded-3" rows="2" placeholder="Tulis catatan untuk penjual jika perlu"></textarea>
          </div>
        </div>

        <!-- PEMBAYARAN -->
        <h5 class="fw-bold text-success mb-3">
          <i class="bi bi-wallet2 me-2"></i> Metode Pembayaran
        </h5>

        <div class="d-flex flex-column flex-md-row gap-3 mb-4">
          <div class="form-check border p-3 rounded-3 shadow-sm w-100 bg-light">
            <input class="form-check-input payment-method" type="radio" name="payment_method" id="cod" value="cash" checked>
            <label class="form-check-label fw-semibold" for="cod">
              💵 Bayar di Tempat (COD)
            </label>
            <p class="small text-muted mb-0">Bayar langsung ke kurir saat pesanan tiba.</p>
          </div>
          <div class="form-check border p-3 rounded-3 shadow-sm w-100 bg-light">
            <input class="form-check-input payment-method" type="radio" name="payment_method" id="transfer" value="transfer">
            <label class="form-check-label fw-semibold" for="transfer">
              💳 Transfer Bank
            </label>
            <p class="small text-muted mb-0">Upload bukti transfer setelah melakukan pembayaran.</p>
          </div>
        </div>

        <!-- INFORMASI REKENING & UPLOAD BUKTI -->
        <div id="transfer-section" class="border p-3 rounded-4 bg-light d-none">
          <p class="mb-2 fw-semibold text-success">Nomor Rekening Toko:</p>
          <p class="mb-0">🏦 <strong>BANK BRI</strong> - 1234 5678 9012 a.n <strong>Bakso Siocay</strong></p>
          <p class="small text-muted mb-3">Transfer sesuai total pembayaran di atas, lalu upload bukti transfer di bawah ini.</p>

          <div class="mb-3">
            <label class="form-label fw-semibold">Upload Bukti Transfer</label>
            <input type="file" name="bukti_transfer" id="bukti_transfer" class="form-control rounded-3" accept="image/*">
            <small class="text-muted">Format: JPG, PNG, maksimal 2MB.</small>
          </div>
        </div>

        <button type="submit" class="btn btn-success btn-lg w-100 shadow-sm rounded-pill mt-3">
          <i class="bi bi-bag-check-fill me-2"></i> Konfirmasi & Pesan Sekarang
        </button>
      </form>
    </div>
  @endif
</div>

{{-- SCRIPT INTERAKTIF --}}
<script>
document.addEventListener('DOMContentLoaded', () => {
  const cod = document.getElementById('cod');
  const transfer = document.getElementById('transfer');
  const transferSection = document.getElementById('transfer-section');
  const uploadInput = document.getElementById('bukti_transfer');

  function toggleTransferSection() {
    if (transfer.checked) {
      transferSection.classList.remove('d-none');
      uploadInput.setAttribute('required', 'required');
    } else {
      transferSection.classList.add('d-none');
      uploadInput.removeAttribute('required');
    }
  }

  cod.addEventListener('change', toggleTransferSection);
  transfer.addEventListener('change', toggleTransferSection);
  toggleTransferSection();
});
</script>

<style>
.form-check-input:checked {
  background-color: #198754;
  border-color: #198754;
}
#transfer-section {
  transition: all 0.3s ease;
}
</style>
@endsection
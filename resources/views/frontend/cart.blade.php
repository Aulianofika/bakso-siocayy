@extends('layouts.frontend')
@section('title', 'Keranjang Saya')

@section('content')
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="d-flex align-items-center">
                <a href="javascript:history.back()"
                    class="btn btn-outline-secondary rounded-circle me-3 shadow-sm d-flex align-items-center justify-content-center"
                    style="width: 40px; height: 40px;">
                    <i class="bi bi-arrow-left"></i>
                </a>
                <h3 class="fw-bold text-success mb-0">
                    <i class="bi bi-cart4 me-2"></i> Keranjang
                </h3>
            </div>
            <a href="{{ route('menu') }}"
                class="btn btn-outline-success rounded-pill d-none d-md-inline-flex align-items-center">
                <i class="bi bi-shop me-2"></i> Lanjut Belanja
            </a>
        </div>

        @if($cartItems->isEmpty())
            <div class="alert alert-warning text-center shadow-sm p-5 rounded-4 bg-white border-0">
                <div class="mb-3">
                    <i class="bi bi-cart-x text-warning" style="font-size: 4rem;"></i>
                </div>
                <h4 class="fw-bold text-muted">Wah, keranjangmu kosong!</h4>
                <p class="text-muted mb-4">Sepertinya kamu belum memilih menu favoritmu.</p>
                <a href="{{ route('menu') }}" class="btn btn-success rounded-pill px-4 py-2 fw-semibold shadow-sm">
                    Mulai Pesan Sekarang
                </a>
            </div>
        @else
            <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden">
                @if($cartItems->contains(fn($item) => $item->product->stock <= 0))
                    <div class="alert alert-danger m-3 mb-0 d-flex align-items-center" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2 fs-4"></i>
                        <div>
                            <strong>Stok Habis!</strong> Beberapa produk di keranjangmu stoknya habis dan tidak dapat dipilih untuk
                            checkout.
                        </div>
                    </div>
                @endif
                <form action="{{ route('checkout.index') }}" method="GET" id="cartForm">
                    @csrf

                    {{-- Desktop Header --}}
                    <div class="d-none d-md-flex align-items-center p-3 bg-light border-bottom fw-semibold text-muted">
                        <div class="col-md-1 text-center">
                            <input type="checkbox" id="select-all" class="form-check-input" style="cursor: pointer;">
                        </div>
                        <div class="col-md-5">Produk</div>
                        <div class="col-md-2 text-center">Harga</div>
                        <div class="col-md-2 text-center">Jumlah</div>
                        <div class="col-md-2 text-end">Subtotal</div>
                    </div>

                    {{-- Cart Items List --}}
                    <div class="cart-items-container">
                        @foreach($cartItems as $item)
                            <div class="cart-row p-3 border-bottom position-relative" data-id="{{ $item->id }}">
                                <div class="row align-items-center g-3">

                                    {{-- Checkbox --}}
                                    <div class="col-2 col-md-1 text-center">
                                        @if($item->product->stock > 0)
                                            <input type="checkbox" name="selected_items[]" value="{{ $item->id }}"
                                                class="form-check-input item-checkbox fs-5" style="cursor: pointer;">
                                        @else
                                            <input type="checkbox" disabled class="form-check-input fs-5 bg-secondary border-secondary"
                                                title="Stok Habis">
                                        @endif
                                    </div>

                                    {{-- Image --}}
                                    <div class="col-3 col-md-1">
                                        <img src="{{ asset('images/products/' . $item->product->image) }}"
                                            alt="{{ $item->product->name }}" class="rounded-3 shadow-sm w-100 object-fit-cover"
                                            style="aspect-ratio: 1/1;">
                                    </div>

                                    {{-- Product Details --}}
                                    <div class="col-7 col-md-4">
                                        <h6 class="fw-bold mb-1 text-dark">{{ $item->product->name }}</h6>
                                        <span class="badge bg-light text-secondary border rounded-pill mb-2">
                                            {{ $item->product->category->name ?? 'Menu' }}
                                        </span>

                                        {{-- Stock Info / Warning codes --}}
                                        @if($item->product->stock == 0)
                                            <br><span class="badge bg-danger">Stok Habis</span>
                                        @elseif($item->quantity > $item->product->stock)
                                            <br><small class="text-danger fw-bold">
                                                <i class="bi bi-exclamation-circle"></i> Stok sisa: {{ $item->product->stock }}
                                            </small>
                                        @endif

                                        {{-- Mobile Price Info --}}
                                        <div class="d-md-none">
                                            <small class="text-muted">Harga: </small>
                                            <span class="fw-semibold text-success price"
                                                data-price="{{ $item->product->price_sale }}">
                                                Rp {{ number_format($item->product->price_sale, 0, ',', '.') }}
                                            </span>
                                        </div>
                                    </div>

                                    {{-- Desktop Price --}}
                                    <div class="d-none d-md-block col-md-2 text-center">
                                        <span class="fw-semibold text-muted price desktop-price"
                                            data-price="{{ $item->product->price_sale }}">
                                            Rp {{ number_format($item->product->price_sale, 0, ',', '.') }}
                                        </span>
                                    </div>

                                    {{-- Quantity & Action Controls --}}
                                    <div class="col-12 col-md-2">
                                        <div
                                            class="d-flex align-items-center justify-content-between justify-content-md-center bg-light rounded-pill p-1 border">
                                            <button type="button"
                                                class="btn btn-sm btn-link text-decoration-none text-success p-0 quantity-btn decrease"
                                                style="width: 30px; height: 30px;">
                                                <i class="bi bi-dash-circle-fill fs-5"></i>
                                            </button>
                                            <input type="text" readonly
                                                class="form-control-plaintext text-center fw-bold quantity-text p-0"
                                                value="{{ $item->quantity }}" data-quantity="{{ $item->quantity }}"
                                                style="width: 40px;">
                                            <button type="button"
                                                class="btn btn-sm btn-link text-decoration-none text-success p-0 quantity-btn increase"
                                                style="width: 30px; height: 30px;">
                                                <i class="bi bi-plus-circle-fill fs-5"></i>
                                            </button>
                                        </div>
                                    </div>

                                    {{-- Subtotal & Delete --}}
                                    <div
                                        class="col-12 col-md-2 d-flex justify-content-between align-items-center justify-content-md-end mt-3 mt-md-0">
                                        <div class="d-md-none">
                                            <small class="text-muted">Total:</small>
                                        </div>
                                        <div class="text-end">
                                            <div class="fw-bold text-success fs-5 subtotal">
                                                Rp {{ number_format($item->product->price_sale * $item->quantity, 0, ',', '.') }}
                                            </div>
                                        </div>

                                        {{-- Delete Button (Hidden Form Trigger) --}}
                                        <button type="submit" form="delete-form-{{ $item->id }}"
                                            class="btn btn-outline-danger btn-sm rounded-circle ms-3 d-flex align-items-center justify-content-center"
                                            style="width: 35px; height: 35px;" title="Hapus Menu">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Footer Action Bar --}}
                    <div class="p-4 bg-light">
                        <div class="row align-items-center gy-3">
                            <div class="col-12 col-md-6">
                                <div
                                    class="d-flex align-items-center justify-content-between justify-content-md-start gap-md-3">
                                    <span class="text-muted">Total Pilihan:</span>
                                    <h3 class="fw-bold text-success mb-0" id="grand-total">Rp 0</h3>
                                </div>
                                <small class="text-muted d-block mt-1">
                                    <i class="bi bi-info-circle me-1"></i> Centang menu yang ingin dipesan
                                </small>
                            </div>
                            <div class="col-12 col-md-6 text-md-end d-flex gap-2 justify-content-end">
                                {{-- Mobile "Kembali Belanja" visible here too --}}
                                <a href="{{ route('menu') }}"
                                    class="btn btn-outline-success rounded-pill d-md-none flex-grow-1">
                                    <i class="bi bi-shop"></i> Belanja
                                </a>
                                <button type="submit"
                                    class="btn btn-success rounded-pill px-4 py-2 shadow-sm flex-grow-1 flex-md-grow-0">
                                    Checkout <i class="bi bi-arrow-right ms-2"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>

                {{-- Hidden Delete Forms --}}
                @foreach($cartItems as $item)
                    <form id="delete-form-{{ $item->id }}" action="{{ route('cart.remove', $item->id) }}" method="POST"
                        class="d-none" onsubmit="return confirm('Yakin ingin menghapus menu ini?')">
                        @csrf
                        @method('DELETE')
                    </form>
                @endforeach
            </div>
        @endif
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const checkboxes = document.querySelectorAll('.item-checkbox');
            const selectAll = document.getElementById('select-all');
            const grandTotalElement = document.getElementById('grand-total');

            function formatRupiah(number) {
                return 'Rp ' + number.toLocaleString('id-ID');
            }

            function updateGrandTotal() {
                let total = 0;
                document.querySelectorAll('.item-checkbox:checked').forEach(chk => {
                    const row = chk.closest('.cart-row');
                    // Remove 'Rp ' and dots to parse int
                    const subtotalText = row.querySelector('.subtotal').textContent.replace(/[^\d]/g, '');
                    total += parseInt(subtotalText) || 0;
                });
                grandTotalElement.textContent = formatRupiah(total);
            }

            if (selectAll) {
                selectAll.addEventListener('change', function () {
                    checkboxes.forEach(chk => chk.checked = this.checked);
                    updateGrandTotal();
                });
            }

            checkboxes.forEach(chk => chk.addEventListener('change', updateGrandTotal));

            document.querySelectorAll('.quantity-btn').forEach(btn => {
                btn.addEventListener('click', function () {
                    const row = btn.closest('.cart-row');
                    const qtyInput = row.querySelector('.quantity-text');
                    const cartId = row.dataset.id;
                    const price = parseInt(row.querySelector('.price').dataset.price);
                    let qty = parseInt(qtyInput.value);

                    if (btn.classList.contains('increase')) qty++;
                    if (btn.classList.contains('decrease') && qty > 1) qty--;

                    // Simpan quantity lama untuk rollback jika error
                    const oldQty = qtyInput.dataset.quantity;

                    // Update UI Sementara (Optimistic UI)
                    qtyInput.value = qty;
                    // qtyInput.dataset.quantity = qty; // Jangan update dataset dulu sebelum sukses

                    // Debounce / Kirim Request AJAX
                    updateCartQuantity(cartId, qty, row, qtyInput, price, oldQty);
                });
            });

            async function updateCartQuantity(cartId, qty, row, qtyInput, price, oldQty) {
                try {
                    const response = await fetch('{{ route('cart.update') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            id: cartId,
                            quantity: qty
                        })
                    });

                    const data = await response.json();

                    if (data.success) {
                        // Update dataset quantity jika sukses
                        qtyInput.dataset.quantity = qty;

                        // Update Subtotal dengan data dari server (lebih akurat) atau hitung manual
                        row.querySelector('.subtotal').textContent = formatRupiah(data.subtotal);
                        updateGrandTotal();
                    } else {
                        // Revert jika gagal (misal stok habis)
                        alert(data.message);
                        qtyInput.value = oldQty;
                    }
                } catch (error) {
                    console.error('Error updating cart:', error);
                    alert('Terjadi kesalahan saat memperbarui keranjang.');
                    qtyInput.value = oldQty;
                }
            }

            // Initial calcs
            updateGrandTotal();

            // Checkout Validation
            const cartForm = document.getElementById('cartForm');
            cartForm.addEventListener('submit', function (e) {
                const selected = document.querySelectorAll('.item-checkbox:checked');
                if (selected.length === 0) {
                    e.preventDefault();

                    // Cek apakah ada item yang stoknya habis (checkbox disabled)
                    const hasOutOfStock = document.querySelectorAll('input[type="checkbox"][disabled]').length > 0;

                    if (hasOutOfStock) {
                        alert('Maaf, stok produk habis. Kamu tidak bisa melakukan checkout untuk produk ini.');
                    } else {
                        alert('Silakan pilih minimal satu produk untuk checkout!');
                    }
                }
            });
        });
    </script>

    <style>
        /* Custom Minimalist Tweaks */
        .form-check-input:checked {
            background-color: #198754;
            border-color: #198754;
        }

        .form-check-input {
            width: 1.25em;
            height: 1.25em;
            border: 2px solid #dee2e6;
        }

        .cart-row:last-child {
            border-bottom: none !important;
        }

        .quantity-text {
            background: transparent;
            border: none;
            font-size: 1.1rem;
        }

        /* Smooth transition for hover effects if desired */
        .btn {
            transition: all 0.2s ease;
        }
    </style>
@endsection
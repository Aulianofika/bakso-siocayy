@extends('layouts.admin')

@section('title', 'Tambah Produk')

@section('content')
    <div class="container-fluid" style="max-width: 900px;">
        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-5 mt-3">
            <div>
                <h4 class="fw-bold" style="color:#4a3aff;" ><i class="bi bi-plus-square me-2"></i>Tambah Produk Baru</h4>
                <span class="text-muted small">Isi formulir di bawah untuk menambahkan produk ke katalog.</span>
            </div>
            <a href="{{ route('admin.products.index') }}" class="btn btn-light rounded-circle shadow-sm"
                style="width: 40px; height: 40px; display: grid; place-items: center;" data-bs-toggle="tooltip"
                title="Kembali">
                <i class="bi bi-arrow-left"></i>
            </a>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger shadow-sm rounded-4 border-0 mb-4">
                <ul class="mb-0 small">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row g-4">
                        {{-- General Info --}}
                        <div class="col-12">
                            <label class="form-label text-uppercase xsmall fw-bold text-muted ls-1 mb-3">Informasi
                                Utama</label>
                            <div class="row g-3">
                                <div class="col-md-8">
                                    <label class="form-label fw-semibold">Nama Produk</label>
                                    <input type="text" name="name" class="form-control"
                                        placeholder="Contoh: Bakso Aci Spesial" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Kategori</label>
                                    <select name="category_id" class="form-select" required>
                                        <option value="">-- Pilih Kategori --</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label for="description" class="form-label fw-semibold">Deskripsi</label>
                                    <textarea name="description" id="description" class="form-control" rows="3"
                                        placeholder="Jelaskan detail produk...">{{ old('description') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <hr class="text-muted opacity-25">
                        </div>

                        {{-- Pricing & Stock --}}
                        <div class="col-12">
                            <label class="form-label text-uppercase xsmall fw-bold text-muted ls-1 mb-3">Harga &
                                Stok</label>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Harga Pokok</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">Rp</span>
                                        <input type="number" name="price_cost" class="form-control border-start-0 ps-0"
                                            placeholder="0" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Harga Jual</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">Rp</span>
                                        <input type="number" name="price_sale" class="form-control border-start-0 ps-0"
                                            placeholder="0" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Stok Awal</label>
                                    <input type="number" name="stock" class="form-control" placeholder="0" required>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <hr class="text-muted opacity-25">
                        </div>

                        {{-- Image --}}
                        <div class="col-12">
                            <label class="form-label text-uppercase xsmall fw-bold text-muted ls-1 mb-3">Media</label>
                            <div class="border rounded-4 p-4 text-center bg-light border-dashed">
                                <div class="mb-2">
                                    
                                </div>
                                <label for="image" class="btn btn-sm btn-outline-primary rounded-pill px-4 mb-2">
                                    <i class="bi bi-upload me-2"></i> Pilih Gambar
                                </label>
                                <input type="file" name="image" id="image" class="d-none" accept="image/*"
                                    onchange="previewImage(event)">
                                <div class="small text-muted">Format: JPG, PNG, JPEG</div>

                                {{-- Preview Container --}}
                                <div id="imagePreview" class="mt-3 d-none">
                                    <img src="" alt="Preview" class="img-thumbnail rounded-3 shadow-sm"
                                        style="max-height: 150px;">
                                </div>
                            </div>
                        </div>

                        {{-- Actions --}}
                        <div class="col-12 text-end mt-4">
                            <a href="{{ route('admin.products.index') }}"
                                class="btn btn-link text-muted text-decoration-none fw-bold me-2">Batal</a>
                            <button class="btn btn-primary rounded-pill px-5 fw-bold shadow-sm">
                                <i class="bi bi-save me-2"></i> Simpan Produk
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        .xsmall {
            font-size: 0.75rem;
        }

        .ls-1 {
            letter-spacing: 1px;
        }

        .border-dashed {
            border-style: dashed !important;
        }
    </style>

    <script>
        function previewImage(event) {
            const input = event.target;
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    const preview = document.getElementById('imagePreview');
                    const img = preview.querySelector('img');
                    img.src = e.target.result;
                    preview.classList.remove('d-none');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection
@extends('layouts.admin')

@section('title', 'Manajemen Pelanggan')

@section('content')
    <div class="row mb-4">
        <div class="col-12 col-md-6 d-flex align-items-center gap-2">
            <h3 class="fw-bold text-dark mb-0">Daftar Pelanggan</h3>
            <span class="badge bg-primary-subtle text-primary rounded-pill">{{ $customers->total() }} User</span>
        </div>
        <div class="col-12 col-md-6 mt-3 mt-md-0 d-flex justify-content-md-end">
            <form action="{{ route('admin.customers.index') }}" method="GET" class="d-flex gap-2">
                <input type="text" name="search" class="form-control form-control-sm" placeholder="Cari Nama/Email..."
                    value="{{ request('search') }}">
                <button type="submit" class="btn btn-sm btn-dark px-3">Cari</button>
            </form>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3" width="5%">No</th>
                            <th class="py-3">Pelanggan</th>
                            <th class="py-3">Kontak</th>
                            <th class="py-3">Total Order</th>
                            <th class="py-3">Bergabung</th>
                            <th class="text-end pe-4 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($customers as $index => $customer)
                            <tr>
                                <td class="ps-4 text-muted fw-bold">{{ $customers->firstItem() + $index }}</td>
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="avatar-sm rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center fw-bold"
                                            style="width: 36px; height: 36px;">
                                            {{ substr($customer->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <h6 class="mb-0 fw-bold text-dark">{{ $customer->name }}</h6>
                                            <small class="text-muted">{{ $customer->email }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if($customer->phone)
                                        <span class="text-dark small">{{ $customer->phone }}</span>
                                    @else
                                        <span class="text-muted small fst-italic">-</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border">{{ $customer->orders_count ?? 0 }}
                                        Transaksi</span>
                                </td>
                                <td class="text-muted small">
                                    {{ $customer->created_at->translatedFormat('d M Y') }}
                                </td>
                                <td class="text-end pe-4">
                                    <form action="{{ route('admin.customers.destroy', $customer->id) }}" method="POST"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus pelanggan ini? Data order historis mungkin akan terpengaruh.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-link text-danger p-0" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="bi bi-people display-4 opacity-25"></i>
                                    <p class="mt-2 text-secondary">Belum ada data pelanggan.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($customers->hasPages())
            <div class="card-footer bg-white border-0 py-3">
                {{ $customers->links() }}
            </div>
        @endif
    </div>
@endsection
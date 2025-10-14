@extends('layouts.admin')
@section('title', 'Data Retur Pelanggan')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4 text-success fw-bold">♻️ Data Retur Pelanggan</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('admin.returns.create') }}" class="btn btn-success mb-3">+ Tambah Retur</a>

    <div class="table-responsive shadow rounded">
        <table class="table table-striped table-bordered align-middle">
            <thead class="table-light">
                <tr class="text-center">
                    <th>ID</th>
                    <th>Pesanan</th>
                    <th>Produk</th>
                    <th>Qty</th>
                    <th>Alasan</th>
                    <th>Restock</th>
                    <th>Kerugian</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($returns as $ret)
                    <tr class="text-center">
                        <td>{{ $ret->id }}</td>
                        <td>#{{ $ret->shipment->order->id ?? '-' }}</td>
                        <td>{{ $ret->product->name ?? '-' }}</td>
                        <td>{{ $ret->quantity }}</td>
                        <td>{{ $ret->reason ?? '-' }}</td>
                        <td>
                            <span class="badge bg-{{ $ret->restock ? 'success' : 'danger' }}">
                                {{ $ret->restock ? 'Ya' : 'Tidak' }}
                            </span>
                        </td>
                        <td>Rp {{ number_format($ret->loss, 0, ',', '.') }}</td>
                        <td>
                            <a href="{{ route('admin.returns.show', $ret->id) }}" class="btn btn-sm btn-outline-primary">Detail</a>
                            <a href="{{ route('admin.returns.edit', $ret->id) }}" class="btn btn-sm btn-outline-warning">Edit</a>
                            <form action="{{ route('admin.returns.destroy', $ret->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus retur ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="text-center text-muted py-4">Belum ada retur.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{ $returns->links() }}
    </div>
</div>
@endsection

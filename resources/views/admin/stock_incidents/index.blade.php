@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Data Insiden Stok</h2>

    {{-- Flash message --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Tombol Tambah --}}
    <div class="mb-3">
        <a href="{{ route('admin.stock-incidents.create') }}" class="btn btn-success">
            + Tambah Insiden
        </a>
    </div>

    {{-- Tabel --}}
    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Produk</th>
                <th>Jenis</th>
                <th>Jumlah</th>
                <th>Kerugian</th>
                <th>Restock?</th>
                <th>Catatan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($incidents as $incident)
                <tr>
                    <td>{{ $incident->id }}</td>
                    <td>{{ $incident->product->name ?? '-' }}</td>
                    <td>
                        <span class="badge 
                            @if($incident->type == 'Retur') bg-primary
                            @elseif($incident->type == 'Reject') bg-danger
                            @else bg-secondary
                            @endif">
                            {{ $incident->type }}
                        </span>
                    </td>
                    <td>{{ $incident->quantity }}</td>
                    <td>Rp {{ number_format($incident->loss, 0, ',', '.') }}</td>
                    <td>
                        <span class="badge bg-{{ $incident->restock ? 'success' : 'danger' }}">
                            {{ $incident->restock ? 'Ya' : 'Tidak' }}
                        </span>
                    </td>
                    <td>{{ $incident->note ?? '-' }}</td>
                    <td>
                        <a href="{{ route('admin.stock-incidents.show', $incident->id) }}" class="btn btn-info btn-sm">Detail</a>
                        <a href="{{ route('admin.stock-incidents.edit', $incident->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('admin.stock-incidents.destroy', $incident->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus insiden ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">Belum ada insiden stok</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Pagination --}}
    {{ $incidents->links() }}
</div>
@endsection

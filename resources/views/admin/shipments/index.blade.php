@extends('layouts.admin')

@section('content')
<div class="container">
    <h2 class="mb-4">Daftar Pengiriman</h2>

    <a href="{{ route('admin.shipments.create') }}" class="btn btn-success mb-3">+ Tambah Pengiriman</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Pesanan</th>
                <th>Tujuan</th>
                <th>Tanggal</th>
                <th>Kurir</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($shipments as $shipment)
                <tr>
                    <td>{{ $shipment->id }}</td>
                    <td>#{{ $shipment->order->id }}</td>
                    <td>{{ $shipment->destination }}</td>
                    <td>{{ $shipment->shipment_date }}</td>
                    <td>{{ $shipment->courier }}</td>
                    <td>
                        <a href="{{ route('admin.shipments.show', $shipment->id) }}" class="btn btn-info btn-sm">Detail</a>
                        <a href="{{ route('admin.shipments.edit', $shipment->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('admin.shipments.destroy', $shipment->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Yakin hapus data?')" class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $shipments->links() }}
</div>
@endsection

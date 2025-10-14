@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Detail Insiden Stok</h1>

    <table class="table table-bordered">
        <tr>
            <th>ID</th>
            <td>{{ $stockIncident->id }}</td>
        </tr>
        <tr>
            <th>Produk</th>
            <td>{{ $stockIncident->product->name }}</td>
        </tr>
        <tr>
            <th>Jenis Insiden</th>
            <td>{{ $stockIncident->type }}</td>
        </tr>
        <tr>
            <th>Jumlah</th>
            <td>{{ $stockIncident->quantity }}</td>
        </tr>
        <tr>
            <th>Kerugian (Rp)</th>
            <td>{{ number_format($stockIncident->loss, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <th>Restock</th>
            <td>{{ $stockIncident->restock ? 'Ya' : 'Tidak' }}</td>
        </tr>
        <tr>
            <th>Catatan</th>
            <td>{{ $stockIncident->note }}</td>
        </tr>
        <tr>
            <th>Dibuat Pada</th>
            <td>{{ $stockIncident->created_at }}</td>
        </tr>
        <tr>
            <th>Diperbarui Pada</th>
            <td>{{ $stockIncident->updated_at }}</td>
        </tr>
    </table>

    <a href="{{ route('admin.stock-incidents.index') }}" class="btn btn-secondary">Kembali</a>
    <a href="{{ route('admin.stock-incidents.edit', $stockIncident->id) }}" class="btn btn-warning">Edit</a>
</div>
@endsection

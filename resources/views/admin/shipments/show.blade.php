@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>Detail Pengiriman</h2>

    <table class="table table-bordered">
        <tr>
            <th>ID</th>
            <td>{{ $shipment->id }}</td>
        </tr>
        <tr>
            <th>Pesanan</th>
            <td>#{{ $shipment->order->id }}</td>
        </tr>
        <tr>
            <th>Tujuan</th>
            <td>{{ $shipment->destination }}</td>
        </tr>
        <tr>
            <th>Tanggal</th>
            <td>{{ $shipment->shipment_date }}</td>
        </tr>
        <tr>
            <th>Kurir</th>
            <td>{{ $shipment->courier }}</td>
        </tr>
    </table>

    <a href="{{ route('admin.shipments.index') }}" class="btn btn-secondary">Kembali</a>
</div>
@endsection

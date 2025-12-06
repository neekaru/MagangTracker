@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Logbook Mahasiswa Bimbingan</h1>
    <table class="table">
        <thead>
            <tr>
                <th>Mahasiswa</th>
                <th>Tanggal</th>
                <th>Deskripsi</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($logbooks as $logbook)
            <tr>
                <td>{{ $logbook->magang->mahasiswa->nama_lengkap ?? 'N/A' }}</td>
                <td>{{ $logbook->tanggal_logbook }}</td>
                <td>{{ Str::limit($logbook->deskripsi_kegiatan, 50) }}</td>
                <td>{{ $logbook->status }}</td>
                <td>
                    <form action="{{ route('pembimbing.logbook.update', $logbook) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <select name="status" onchange="this.form.submit()">
                            <option value="pending" {{ $logbook->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="approved" {{ $logbook->status == 'approved' ? 'selected' : '' }}>Approve</option>
                            <option value="rejected" {{ $logbook->status == 'rejected' ? 'selected' : '' }}>Reject</option>
                        </select>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
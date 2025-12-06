@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Logbook</h1>
    <form action="{{ route('logbook.update', $logbook) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control" required>
                <option value="pending" {{ $logbook->status == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="approved" {{ $logbook->status == 'approved' ? 'selected' : '' }}>Approved</option>
                <option value="rejected" {{ $logbook->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Approved By</label>
            <input type="number" name="approved_by" class="form-control" value="{{ $logbook->approved_by }}">
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
@extends('layouts.app')

@section('title', $attendance->exists ? 'Edit Attendance' : 'Mark Attendance')

@section('content')
    <x-page-header :title="$attendance->exists ? 'Edit Attendance' : 'Mark Attendance'" />

    <div class="card card-round">
        <div class="card-body">
            <form method="POST" action="{{ $attendance->exists ? route('attendances.update', $attendance) : route('attendances.store') }}">
                @csrf
                @if ($attendance->exists) @method('PUT') @endif

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Contractor</label>
                            <select name="contractor_id" class="form-select" required>
                                <option value="">-- Select contractor --</option>
                                @foreach ($contractors as $contractor)
                                    <option value="{{ $contractor->id }}" @selected(old('contractor_id', $attendance->contractor_id) == $contractor->id)>{{ $contractor->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Date</label>
                            <input type="date" name="date" class="form-control" value="{{ old('date', optional($attendance->date)->format('Y-m-d')) }}" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Status</label>
                            <select name="status" class="form-select">
                                <option value="present" @selected(old('status', $attendance->status) === 'present')>Present</option>
                                <option value="absent" @selected(old('status', $attendance->status) === 'absent')>Absent</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="card-action">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <a href="{{ route('attendances.index') }}" class="btn btn-border">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection

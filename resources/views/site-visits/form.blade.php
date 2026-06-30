@extends('layouts.app')

@section('title', $siteVisit->exists ? 'Edit Site Visit' : 'Record Site Visit')

@section('content')
    <x-page-header :title="$siteVisit->exists ? 'Edit Site Visit' : 'Record Site Visit'" />

    <div class="card card-round">
        <div class="card-body">
            <form method="POST" action="{{ $siteVisit->exists ? route('site-visits.update', $siteVisit) : route('site-visits.store') }}">
                @csrf
                @if ($siteVisit->exists) @method('PUT') @endif

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Lead</label>
                            <select name="lead_id" class="form-select" required>
                                <option value="">-- Select lead --</option>
                                @foreach ($leads as $lead)
                                    <option value="{{ $lead->id }}" @selected(old('lead_id', $siteVisit->lead_id) == $lead->id)>
                                        {{ $lead->customer->name ?? 'Lead #' . $lead->id }} ({{ $lead->status }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Visit Date</label>
                            <input type="datetime-local" name="visit_date" class="form-control" value="{{ old('visit_date', optional($siteVisit->visit_date)->format('Y-m-d\TH:i')) }}">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Feedback</label>
                            <textarea name="feedback" class="form-control" rows="3">{{ old('feedback', $siteVisit->feedback) }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="card-action">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <a href="{{ route('site-visits.index') }}" class="btn btn-border">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection

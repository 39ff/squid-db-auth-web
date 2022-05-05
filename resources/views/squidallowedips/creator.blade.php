@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Add AllowedIP') }}</div>

                    <div class="card-body">

                        <form method="post" action="{{ route('ip.create',request()->user()->id) }}">
                            <div class="mb-3">
                                <label for="ip" class="form-label">IP Address</label>
                                <input type="text" class="form-control" id="ip" name="ip" value="{{ old('ip',$ip ?? '') }}">
                            </div>

                            <button type="submit" class="btn btn-primary mb-3">Add</button>

                            @csrf
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

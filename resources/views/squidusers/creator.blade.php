@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Create SquidUser') }}</div>

                    <div class="card-body">

                        <form method="post" action="{{ route('squiduser.create',request()->user()->id) }}">
                            @include('squidusers.commons.form',['submit'=>'Create'])
                            @csrf
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

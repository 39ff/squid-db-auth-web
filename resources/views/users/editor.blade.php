@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Modify User') }}</div>

                    <div class="card-body">

                        <form method="post" action="{{ route('user.modify',$id) }}">
                            @include('users.commons.form',['submit'=>'Modify'])
                            @csrf
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

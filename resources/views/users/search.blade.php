@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Search Users') }}</div>
                    <div class="card-body">
                        <table class="table table-sm table-hover">
                            <a href="{{ route('user.creator') }}">Create User</a>
                            <thead>
                            <tr>
                                <th scope="col">{{ __('Id') }}</th>
                                <th scope="col">{{ __('Name') }}</th>
                                <th scope="col">{{ __('Email') }}</th>
                                <th scope="col">{{ __('Options') }}</th>
                                <th scope="col">{{ __('Actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <th scope="row">{{ $user->id }}</th>
                                    <td>{{{ $user->name }}}</td>
                                    <td>
                                        <a href="{{ route('user.editor',$user->id) }}">{{ $user->email }}</a>
                                    </td>
                                    <td>
                                        @if($user->is_administrator == 1)
                                            <span class="badge bg-primary">{{ __('Admin') }}</span>
                                        @endif
                                    </td>
                                    <td>
                                       <form method="post" action="{{ route('user.destroy',$user->id) }}">
                                           <input class="btn btn-sm btn-danger" type="submit" value="Destroy">
                                           @csrf
                                       </form>
                                    </td>
                                </tr>
                            @endforeach


                            </tbody>
                        </table>

                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

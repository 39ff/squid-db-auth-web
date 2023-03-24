@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Search SquidUsers') }}</div>
                    <div class="card-body">
                        <table class="table table-sm table-hover">
                            <a href="{{ route('squiduser.creator') }}">Create SquidUser</a>
                            <thead>
                            <tr>
                                @can('create-user')
                                    <th scope="col">{{ __('Id') }}</th>
                                    <th scope="col">{{ __('Name') }}</th>
                                @endcan
                                <th scope="col">{{ __('User') }}</th>
                                <th scope="col">{{ __('Enabled') }}</th>
                                <th scope="col">{{ __('FullName') }}</th>
                                <th scope="col">{{ __('Comment') }}</th>
                                <th scope="col">{{ __('Actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($users as $user)
                                <tr>
                                    @can('create-user')
                                        <th scope="row">{{ $user->id }}</th>
                                        <td>{{{ $user->laravel_user->name }}}</td>
                                    @endcan
                                    <td><a href="{{ route('squiduser.editor',$user->id) }}">{{{ $user->user }}}</a></td>
                                    <td>
                                        @if($user->enabled == 1)
                                            <span class="badge bg-success">{{ __('Enabled') }}</span>
                                        @else
                                            <span class="badge bg-danger">{{ __('Disabled') }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $user->fullname }}</td>
                                    <td>{{ $user->comment }}</td>
                                    <td>
                                        <form method="post" action="{{ route('squiduser.destroy',$user->id) }}">
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

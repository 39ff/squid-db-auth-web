@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Search AllowedIPs') }}</div>
                    <div class="card-body">
                        <table class="table table-sm table-hover">
                            <a href="{{ route('ip.creator') }}">{{ __('Add AllowedIPs') }}</a>
                            <thead>
                            <tr>
                                @can('create-user')
                                    <th scope="col">{{ __('Id') }}</th>
                                    <th scope="col">{{ __('UserId') }}</th>
                                @endcan
                                <th scope="col">{{ __('IP') }}</th>
                                <th scope="col">{{ __('Actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($ips as $ip)
                                <tr>
                                    @can('create-user')
                                    <td>{{ $ip->id }}</td>
                                    <td>{{ $ip->user_id }}</td>
                                    @endcan
                                    <td>{{{ $ip->ip }}}</td>
                                    <td>
                                        <form method="post" action="{{ route('ip.destroy',$ip->id) }}">
                                            <input class="btn btn-sm btn-danger" type="submit" value="Destroy">
                                            @csrf
                                        </form>
                                    </td>
                                </tr>
                            @endforeach


                            </tbody>
                        </table>

                        {{ $ips->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">{{ __('Bulk Import SquidUsers (CSV)') }}</div>

                    <div class="card-body">
                        @if(session('message'))
                            <div class="alert alert-info">
                                <h5>{{ __('Import Results') }}</h5>
                                <pre>{{ session('message') }}</pre>
                            </div>
                        @endif

                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('squiduser.bulk.import') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-4">
                                <h5>{{ __('CSV Format Instructions') }}</h5>
                                <div class="alert alert-secondary">
                                    <p class="mb-2"><strong>{{ __('CSV Header (First Row):') }}</strong></p>
                                    <code>user,password,enabled,fullname,comment</code>

                                    <p class="mt-3 mb-2"><strong>{{ __('Example for CREATE:') }}</strong></p>
                                    <pre class="mb-0">user,password,enabled,fullname,comment
testuser1,password123,1,Test User One,First test user
testuser2,password456,1,Test User Two,Second test user</pre>

                                    <p class="mt-3 mb-2"><strong>{{ __('Example for UPDATE:') }}</strong></p>
                                    <pre class="mb-0">user,password,enabled,fullname,comment
testuser1,newpassword,0,Updated Name,Updated comment</pre>
                                    <small class="text-muted">{{ __('Note: For UPDATE, the "user" field is used to find existing records. Empty fields will not be updated.') }}</small>

                                    <p class="mt-3 mb-2"><strong>{{ __('Example for DELETE:') }}</strong></p>
                                    <pre class="mb-0">user,password,enabled,fullname,comment
testuser1,,,,</pre>
                                    <small class="text-muted">{{ __('Note: For DELETE, only the "user" field is required.') }}</small>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="operation" class="form-label">{{ __('Operation Type') }}</label>
                                <select name="operation" id="operation" class="form-select" required>
                                    <option value="">{{ __('Select Operation') }}</option>
                                    <option value="create">{{ __('Create (Add new users)') }}</option>
                                    <option value="update">{{ __('Update (Modify existing users)') }}</option>
                                    <option value="delete">{{ __('Delete (Remove users)') }}</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="csv_file" class="form-label">{{ __('CSV File') }}</label>
                                <input type="file" name="csv_file" id="csv_file" class="form-control" accept=".csv,.txt" required>
                                <small class="form-text text-muted">
                                    {{ __('Maximum file size: 10MB. Supported formats: .csv, .txt') }}
                                </small>
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <a href="{{ route('squiduser.search', auth()->user()->id) }}" class="btn btn-secondary">
                                    {{ __('Back to List') }}
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Upload and Process') }}
                                </button>
                            </div>
                        </form>

                        <hr class="my-4">

                        <div class="alert alert-warning">
                            <h6 class="alert-heading">{{ __('Important Notes:') }}</h6>
                            <ul class="mb-0">
                                <li>{{ __('The CSV file must use comma (,) as delimiter') }}</li>
                                <li>{{ __('The first row must contain column headers') }}</li>
                                <li>{{ __('For CREATE operation, all fields are required except fullname and comment') }}</li>
                                <li>{{ __('For UPDATE operation, existing users are matched by the "user" field') }}</li>
                                <li>{{ __('For DELETE operation, only the "user" field is needed') }}</li>
                                <li>{{ __('All operations are executed in a transaction - if one fails, all will be rolled back') }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

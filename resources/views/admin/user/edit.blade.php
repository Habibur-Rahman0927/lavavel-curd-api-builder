@extends('layouts/layout')

@section('title', 'Edit User')

@section('page-style')
    @vite([])
@endsection

@section('page-script')
    @vite([])
@endsection

@section('content')
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Edit User</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item active">User</li>
            </ol>
        </nav>
    </div>
    <section class="section dashboard">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"></h5>

                {{-- Show Validation Errors --}}
                {{-- @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif --}}
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form class="" method="POST" action="{{ route('user.update', $data->id) }}">
                    @csrf
                    @method('PUT') <!-- Use PUT method for updating -->
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" value="{{ old('name', $data->name) }}">
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
    
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email" value="{{ old('email', $data->email) }}">
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
    
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="password" class="form-label">Password (leave blank to keep current)</label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password">
                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Select User Type</label>
                            <select class="form-select @error('user_type') is-invalid @enderror" name="user_type">
                                <option value="" selected>-- Select User Type --</option>
                                <option value="1" {{ $data->user_type == 1 ? 'selected' : '' }}>Default</option>
                                <option value="2" {{ $data->user_type == 2 ? 'selected' : '' }}>Super Admin</option>
                                <option value="3" {{ $data->user_type == 3 ? 'selected' : '' }}>Admin</option>
                            </select>
                            @error('user_type')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
    
                        <div class="col-md-6">
                            <label class="form-label">Select User Role</label>
                            <select class="form-select @error('role') is-invalid @enderror" name="role">
                                <option value="" selected>-- Select User Role --</option>
                                <option value="1" {{ $data->role == 1 ? 'selected' : '' }}>One</option>
                                <option value="2" {{ $data->role == 2 ? 'selected' : '' }}>Two</option>
                                <option value="3" {{ $data->role == 3 ? 'selected' : '' }}>Three</option>
                            </select>
                            @error('role')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label class="form-label">Status</label>
                            <div class="form-check form-switch">
                                <input class="form-check-input @error('is_active') is-invalid @enderror" type="checkbox" role="switch" id="statusToggle" name="is_active" value="1" {{ $data->is_active ? 'checked' : '' }}>
                                <label class="form-check-label" for="statusToggle">
                                    <span class="text-success">Active</span> / <span class="text-danger">Inactive</span>
                                </label>
                            </div>
                            @error('is_active')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
    
                    <div class="row">
                        <div class="col-md-12 text-end"> 
                            <a href="{{ route('user.index') }}" class="btn btn-secondary me-2">Back</a>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</main>

@endsection

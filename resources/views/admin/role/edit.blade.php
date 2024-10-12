@extends('layouts/layout')

@section('title', 'Edit role')

@section('page-style')
    @vite([])
@endsection

@section('page-script')
    @vite([])
@endsection

@section('content')
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Edit role</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin-dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">role</li>
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

                <form class="" method="POST" action="{{ route('role.update', $data->id) }}">
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
                            <label class="form-label">Status</label>
                            <div class="form-check form-switch">
                                <input class="form-check-input @error('status') is-invalid @enderror" type="checkbox" role="switch" id="statusToggle" name="status" value="1" {{ $data->status ? 'checked' : '' }}>
                                <label class="form-check-label" for="statusToggle">
                                    <span class="text-success">Active</span> / <span class="text-danger">Inactive</span>
                                </label>
                            </div>
                            @error('status')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
    
                    <div class="row">
                        <div class="col-md-12 text-end"> 
                            <a href="{{ route('role.index') }}" class="btn btn-secondary me-2">Back</a>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</main>

@endsection

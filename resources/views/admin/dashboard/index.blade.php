@extends('layouts/layout')

@section('title', 'Admin Dashboard')

@section('page-style')
    @vite([])
    <style>
        /* Base styling for all cards */
.card.info-card {
    color: white;
    height: 150px;
    border-radius: 15px;
    box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.15);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    display: flex;
    align-items: center;
    padding: 1.25rem;
    position: relative;
}

.card.info-card:hover {
    transform: translateY(-5px);
    box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.2);
}

/* Specific background gradients for each card */
.users-card {
    background: linear-gradient(135deg, #0d6efd, #6c757d);
}

.roles-card {
    background: linear-gradient(135deg, #198754, #20c997);
}

.permissions-card {
    background: linear-gradient(135deg, #ffc107, #fd7e14);
}

.permission-groups-card {
    background: linear-gradient(135deg, #dc3545, #e74a3b);
}

/* Layout adjustments */
.card-body {
    display: flex;
    justify-content: space-between;
    width: 100%;
    padding: 0 20px 20px 0px;
}

.icon-title {
    display: flex;
    align-items: center;
}

.icon-circle {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.2);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    margin-right: 0.75rem;
}

/* Title styling */
.icon-title h6 {
    font-size: 1rem;
    font-weight: 600;
    margin: 0;
}

/* Count styling in the top-right */
.count {
    font-size: 1.5rem;
    font-weight: 700;
    position: absolute;
    top: 15px;
    right: 20px;
}



    </style>
@endsection

@section('page-script')
    @vite([])
@endsection

@section('content')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Dashboard</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </nav>
        </div>
        <section class="section dashboard">
            <div class="row">
                <!-- Users Card -->
                <div class="col-lg-3 col-md-6">
                    <div class="card info-card users-card">
                        <div class="card-body d-flex align-items-center">
                            <div>
                                <div class="icon-circle mb-2">
                                    <i class="bi bi-people"></i>
                                </div>
                                <h6>Users</h6>
                            </div>
                            <span class="count">{{ $userCount ?? 0 }}</span>
                        </div>
                    </div>
                </div>
    
                <!-- Roles Card -->
                <div class="col-lg-3 col-md-6">
                    <div class="card info-card roles-card">
                        <div class="card-body d-flex align-items-center">
                            <div>
                                <div class="icon-circle mb-2">
                                    <i class="bi bi-shield-lock"></i>
                                </div>
                                <h6>Roles</h6>
                            </div>
                            <span class="count">{{ $roleCount ?? 0 }}</span>
                        </div>
                    </div>
                </div>
    
                <!-- Permissions Card -->
                <div class="col-lg-3 col-md-6">
                    <div class="card info-card permissions-card">
                        <div class="card-body d-flex align-items-center">
                            <div>
                                <div class="icon-circle mb-2">
                                    <i class="bi bi-key"></i>
                                </div>
                                <h6>Permissions</h6>
                            </div>
                            <span class="count">{{ $permissionCount ?? 0 }}</span>
                        </div>
                    </div>
                </div>
    
                <!-- Permission Groups Card -->
                <div class="col-lg-3 col-md-6">
                    <div class="card info-card permission-groups-card">
                        <div class="card-body d-flex align-items-center">
                            <div>
                                <div class="icon-circle mb-2">
                                    <i class="bi bi-folder"></i>
                                </div>
                                <h6>Permission Groups</h6>
                            </div>
                            <span class="count">{{ $permissionGroupCount ?? 120 }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

@endsection

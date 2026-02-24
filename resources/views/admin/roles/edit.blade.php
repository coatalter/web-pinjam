@extends('layouts.admin')

@section('content')
<div class="container-fluid p-4">

    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex align-items-center gap-2 mb-1">
                <a href="{{ route('admin.roles.index') }}" class="btn btn-sm btn-outline-secondary">
                    <i data-feather="arrow-left" style="width:15px;height:15px;"></i>
                </a>
                <h3 class="mb-0 fw-bold">Edit Role</h3>
            </div>
            <nav aria-label="breadcrumb" class="ms-5">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.roles.index') }}">Role</a></li>
                    <li class="breadcrumb-item active">Edit: {{ $role->name }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom py-3">
                    <div class="d-flex align-items-center gap-2">
                        <div class="p-2 rounded-3 bg-warning bg-opacity-10">
                            <i data-feather="edit-2" class="text-warning" style="width:20px;height:20px;"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 fw-semibold">Edit Role: {{ $role->name }}</h5>
                            <small class="text-muted font-monospace">slug: {{ $role->slug }}</small>
                        </div>
                    </div>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.roles.update', $role) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- Nama Role --}}
                        <div class="mb-4">
                            <label for="name" class="form-label fw-semibold">
                                Nama Role <span class="text-danger">*</span>
                            </label>
                            <input type="text" id="name" name="name"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name', $role->name) }}" autofocus>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Slug --}}
                        <div class="mb-4">
                            <label for="slug" class="form-label fw-semibold">Slug</label>
                            <div class="input-group">
                                <span class="input-group-text text-muted font-monospace small">#</span>
                                <input type="text" id="slug" name="slug"
                                    class="form-control font-monospace @error('slug') is-invalid @enderror"
                                    value="{{ old('slug', $role->slug) }}">
                                @error('slug')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-text text-warning">
                                <i data-feather="alert-triangle" style="width:12px;height:12px;"></i>
                                Mengubah slug bisa mempengaruhi middleware dan akses pengguna yang sudah ada.
                            </div>
                        </div>

                        {{-- Deskripsi --}}
                        <div class="mb-4">
                            <label for="description" class="form-label fw-semibold">Deskripsi</label>
                            <textarea id="description" name="description" rows="3"
                                class="form-control @error('description') is-invalid @enderror">{{ old('description', $role->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Info Pengguna --}}
                        @php $userCount = $role->users()->count(); @endphp
                        @if($userCount > 0)
                        <div class="alert alert-info d-flex align-items-center gap-2">
                            <i data-feather="info" style="width:18px;height:18px;flex-shrink:0;"></i>
                            <span>Role ini saat ini digunakan oleh <strong>{{ $userCount }} pengguna</strong>.</span>
                        </div>
                        @endif

                        <hr class="my-4">

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.roles.show', $role) }}" class="btn btn-outline-info d-flex align-items-center gap-2">
                                <i data-feather="eye" style="width:15px;height:15px;"></i>
                                Lihat Detail
                            </a>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">Batal</a>
                                <button type="submit" class="btn btn-warning d-flex align-items-center gap-2">
                                    <i data-feather="save" style="width:15px;height:15px;"></i>
                                    Update Role
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@extends('layouts.admin')

@section('content')
<div class="container-fluid p-4">

    {{-- Page Header --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3 class="mb-1 fw-bold">Manajemen Role</h3>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Role</li>
                        </ol>
                    </nav>
                </div>
                <a href="{{ route('admin.roles.create') }}" class="btn btn-primary d-flex align-items-center gap-2">
                    <i data-feather="plus" style="width:16px;height:16px;"></i>
                    Tambah Role
                </a>
            </div>
        </div>
    </div>

    {{-- Alert Messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2" role="alert">
            <i data-feather="check-circle" style="width:18px;height:18px;flex-shrink:0;"></i>
            <span>{{ session('success') }}</span>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center gap-2" role="alert">
            <i data-feather="alert-circle" style="width:18px;height:18px;flex-shrink:0;"></i>
            <span>{{ session('error') }}</span>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Stats Cards --}}
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="p-3 rounded-3 bg-primary bg-opacity-10">
                        <i data-feather="shield" class="text-primary" style="width:24px;height:24px;"></i>
                    </div>
                    <div>
                        <div class="fs-4 fw-bold">{{ $roles->total() }}</div>
                        <div class="text-muted small">Total Role Terdaftar</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="p-3 rounded-3 bg-success bg-opacity-10">
                        <i data-feather="users" class="text-success" style="width:24px;height:24px;"></i>
                    </div>
                    <div>
                        <div class="fs-4 fw-bold">{{ $roles->sum('users_count') }}</div>
                        <div class="text-muted small">Total Pengguna</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="p-3 rounded-3 bg-warning bg-opacity-10">
                        <i data-feather="user-x" class="text-warning" style="width:24px;height:24px;"></i>
                    </div>
                    <div>
                        <div class="fs-4 fw-bold">{{ $roles->filter(fn($r) => $r->users_count == 0)->count() }}</div>
                        <div class="text-muted small">Role Tanpa Pengguna</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Table Card --}}
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center py-3">
            <h5 class="mb-0 fw-semibold">Daftar Role</h5>
            {{-- Search --}}
            <form method="GET" action="{{ route('admin.roles.index') }}" class="d-flex gap-2">
                <div class="input-group" style="width:260px;">
                    <span class="input-group-text bg-white border-end-0">
                        <i data-feather="search" style="width:15px;height:15px;"></i>
                    </span>
                    <input type="text" name="search" class="form-control border-start-0 ps-0"
                        placeholder="Cari role..." value="{{ request('search') }}">
                </div>
                @if(request('search'))
                    <a href="{{ route('admin.roles.index') }}" class="btn btn-outline-secondary">Reset</a>
                @endif
            </form>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4" style="width:50px;">#</th>
                            <th>Nama Role</th>
                            <th>Slug</th>
                            <th>Deskripsi</th>
                            <th class="text-center">Pengguna</th>
                            <th class="text-center">Dibuat</th>
                            <th class="text-center pe-4" style="width:130px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($roles as $index => $role)
                        <tr>
                            <td class="ps-4 text-muted">{{ $roles->firstItem() + $index }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center bg-primary bg-opacity-10"
                                        style="width:36px;height:36px;flex-shrink:0;">
                                        <i data-feather="shield" class="text-primary" style="width:16px;height:16px;"></i>
                                    </div>
                                    <div>
                                        <div class="fw-semibold">{{ $role->name }}</div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="badge bg-light text-dark font-monospace">{{ $role->slug }}</span></td>
                            <td class="text-muted" style="max-width:220px;">
                                {{ $role->description ?? '-' }}
                            </td>
                            <td class="text-center">
                                @if($role->users_count > 0)
                                    <a href="{{ route('admin.roles.show', $role) }}" class="badge bg-success text-decoration-none">
                                        {{ $role->users_count }} pengguna
                                    </a>
                                @else
                                    <span class="badge bg-secondary">0</span>
                                @endif
                            </td>
                            <td class="text-center text-muted small">
                                {{ $role->created_at->format('d M Y') }}
                            </td>
                            <td class="text-center pe-4">
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="{{ route('admin.roles.show', $role) }}"
                                        class="btn btn-sm btn-outline-info" title="Detail">
                                        <i data-feather="eye" style="width:14px;height:14px;"></i>
                                    </a>
                                    <a href="{{ route('admin.roles.edit', $role) }}"
                                        class="btn btn-sm btn-outline-warning" title="Edit">
                                        <i data-feather="edit-2" style="width:14px;height:14px;"></i>
                                    </a>
                                    <button type="button"
                                        class="btn btn-sm btn-outline-danger"
                                        title="Hapus"
                                        onclick="confirmDelete('{{ $role->name }}', '{{ route('admin.roles.destroy', $role) }}')">
                                        <i data-feather="trash-2" style="width:14px;height:14px;"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i data-feather="inbox" style="width:40px;height:40px;" class="mb-2 d-block mx-auto opacity-50"></i>
                                @if(request('search'))
                                    Tidak ada role yang cocok dengan pencarian "<strong>{{ request('search') }}</strong>"
                                @else
                                    Belum ada role yang terdaftar.
                                @endif
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($roles->hasPages())
        <div class="card-footer bg-white border-top d-flex justify-content-between align-items-center">
            <small class="text-muted">
                Menampilkan {{ $roles->firstItem() }}–{{ $roles->lastItem() }} dari {{ $roles->total() }} role
            </small>
            {{ $roles->links() }}
        </div>
        @endif
    </div>

</div>

{{-- Delete Confirmation Modal --}}
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center py-4">
                <div class="mb-3">
                    <i data-feather="alert-triangle" class="text-danger" style="width:48px;height:48px;"></i>
                </div>
                <p class="mb-1">Apakah Anda yakin ingin menghapus role</p>
                <p class="fw-bold fs-5 mb-0" id="deleteRoleName"></p>
                <p class="text-muted small mt-2">Role yang memiliki pengguna tidak dapat dihapus.</p>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function confirmDelete(name, url) {
    document.getElementById('deleteRoleName').textContent = name;
    document.getElementById('deleteForm').action = url;
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}
</script>
@endpush
@endsection
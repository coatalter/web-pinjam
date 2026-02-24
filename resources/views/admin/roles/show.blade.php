@extends('layouts.admin')

@section('content')
<div class="container-fluid p-4">

    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex align-items-center gap-2 mb-1">
                <a href="{{ route('admin.roles.index') }}" class="btn btn-sm btn-outline-secondary">
                    <i data-feather="arrow-left" style="width:15px;height:15px;"></i>
                </a>
                <h3 class="mb-0 fw-bold">Detail Role</h3>
            </div>
            <nav aria-label="breadcrumb" class="ms-5">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.roles.index') }}">Role</a></li>
                    <li class="breadcrumb-item active">{{ $role->name }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row g-4">
        {{-- Role Info --}}
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center p-4">
                    <div class="mx-auto mb-3 rounded-circle d-flex align-items-center justify-content-center bg-primary bg-opacity-10"
                        style="width:72px;height:72px;">
                        <i data-feather="shield" class="text-primary" style="width:36px;height:36px;"></i>
                    </div>
                    <h4 class="fw-bold mb-1">{{ $role->name }}</h4>
                    <span class="badge bg-light text-dark font-monospace mb-3">{{ $role->slug }}</span>
                    <p class="text-muted small mb-4">{{ $role->description ?? 'Tidak ada deskripsi.' }}</p>
                    <hr>
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="fs-4 fw-bold text-primary">{{ $role->users_count }}</div>
                            <div class="text-muted small">Pengguna</div>
                        </div>
                        <div class="col-6">
                            <div class="fs-4 fw-bold text-success">{{ $role->menus->count() }}</div>
                            <div class="text-muted small">Menu Akses</div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-white border-top d-flex gap-2">
                    <a href="{{ route('admin.roles.edit', $role) }}" class="btn btn-warning flex-fill">
                        <i data-feather="edit-2" style="width:14px;height:14px;"></i> Edit
                    </a>
                    <button class="btn btn-outline-danger flex-fill"
                        onclick="confirmDelete('{{ $role->name }}', '{{ route('admin.roles.destroy', $role) }}')">
                        <i data-feather="trash-2" style="width:14px;height:14px;"></i> Hapus
                    </button>
                </div>
            </div>

            {{-- Timestamps --}}
            <div class="card border-0 shadow-sm mt-3">
                <div class="card-body">
                    <h6 class="fw-semibold mb-3">Informasi Waktu</h6>
                    <div class="d-flex justify-content-between text-muted small py-2 border-bottom">
                        <span>Dibuat</span>
                        <span>{{ $role->created_at->format('d M Y, H:i') }}</span>
                    </div>
                    <div class="d-flex justify-content-between text-muted small py-2">
                        <span>Diperbarui</span>
                        <span>{{ $role->updated_at->format('d M Y, H:i') }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Users List --}}
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom py-3">
                    <h5 class="mb-0 fw-semibold">
                        Pengguna dengan Role Ini
                        <span class="badge bg-primary ms-2">{{ $role->users_count }}</span>
                    </h5>
                </div>
                <div class="card-body p-0">
                    @if($role->users->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">#</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Bergabung</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($role->users as $i => $user)
                                <tr>
                                    <td class="ps-4 text-muted">{{ $i + 1 }}</td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="rounded-circle bg-secondary bg-opacity-10 d-flex align-items-center justify-content-center"
                                                style="width:32px;height:32px;font-size:13px;font-weight:600;">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>
                                            <span class="fw-semibold">{{ $user->name }}</span>
                                        </div>
                                    </td>
                                    <td class="text-muted">{{ $user->email }}</td>
                                    <td class="text-muted small">{{ $user->created_at->format('d M Y') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="text-center py-5 text-muted">
                        <i data-feather="users" style="width:40px;height:40px;" class="mb-2 d-block mx-auto opacity-50"></i>
                        Belum ada pengguna dengan role ini.
                    </div>
                    @endif
                </div>
            </div>
        </div>
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
                <i data-feather="alert-triangle" class="text-danger mb-3" style="width:48px;height:48px;"></i>
                <p class="mb-1">Apakah Anda yakin ingin menghapus role</p>
                <p class="fw-bold fs-5" id="deleteRoleName"></p>
                <p class="text-muted small">Role yang memiliki pengguna tidak dapat dihapus.</p>
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
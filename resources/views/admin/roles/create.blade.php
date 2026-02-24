@extends('layouts.admin')

@section('content')
<div class="container-fluid p-4">

    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex align-items-center gap-2 mb-1">
                <a href="{{ route('admin.roles.index') }}" class="btn btn-sm btn-outline-secondary">
                    <i data-feather="arrow-left" style="width:15px;height:15px;"></i>
                </a>
                <h3 class="mb-0 fw-bold">Tambah Role Baru</h3>
            </div>
            <nav aria-label="breadcrumb" class="ms-5">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.roles.index') }}">Role</a></li>
                    <li class="breadcrumb-item active">Tambah</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom py-3">
                    <div class="d-flex align-items-center gap-2">
                        <div class="p-2 rounded-3 bg-primary bg-opacity-10">
                            <i data-feather="shield" class="text-primary" style="width:20px;height:20px;"></i>
                        </div>
                        <h5 class="mb-0 fw-semibold">Informasi Role</h5>
                    </div>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.roles.store') }}" method="POST">
                        @csrf

                        {{-- Nama Role --}}
                        <div class="mb-4">
                            <label for="name" class="form-label fw-semibold">
                                Nama Role <span class="text-danger">*</span>
                            </label>
                            <input type="text" id="name" name="name"
                                class="form-control @error('name') is-invalid @enderror"
                                placeholder="Contoh: Mahasiswa, Dosen, Kepala Lab"
                                value="{{ old('name') }}" autofocus>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Nama role yang akan ditampilkan ke pengguna.</div>
                        </div>

                        {{-- Slug --}}
                        <div class="mb-4">
                            <label for="slug" class="form-label fw-semibold">Slug</label>
                            <div class="input-group">
                                <span class="input-group-text text-muted font-monospace small">#</span>
                                <input type="text" id="slug" name="slug"
                                    class="form-control font-monospace @error('slug') is-invalid @enderror"
                                    placeholder="contoh: mahasiswa (otomatis dari nama)"
                                    value="{{ old('slug') }}">
                                @error('slug')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-text">Identifikasi unik untuk sistem. Kosongkan untuk dibuat otomatis dari nama.</div>
                        </div>

                        {{-- Deskripsi --}}
                        <div class="mb-4">
                            <label for="description" class="form-label fw-semibold">Deskripsi</label>
                            <textarea id="description" name="description" rows="3"
                                class="form-control @error('description') is-invalid @enderror"
                                placeholder="Deskripsi singkat tentang role ini...">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Preset Role Universitas --}}
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Preset Role Universitas</label>
                            <div class="p-3 rounded-3 bg-light">
                                <p class="text-muted small mb-2">Klik untuk mengisi nama secara otomatis:</p>
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach([
                                        ['Mahasiswa', 'Mahasiswa aktif yang dapat meminjam alat/lab'],
                                        ['Dosen', 'Dosen pengampu yang dapat meminjam dan menyetujui peminjaman'],
                                        ['Kepala Lab', 'Bertanggung jawab atas pengelolaan laboratorium'],
                                        ['Teknisi Lab', 'Teknisi yang mengelola peralatan dan jadwal lab'],
                                        ['Dekan', 'Dekan Fakultas'],
                                        ['Wakil Dekan', 'Wakil Dekan bidang akademik/kemahasiswaan'],
                                        ['Kaprodi', 'Ketua Program Studi'],
                                        ['Sekretaris Prodi', 'Sekretaris Program Studi'],
                                        ['Staff Fakultas', 'Staff administrasi tingkat fakultas'],
                                        ['Staff Universitas', 'Staff administrasi tingkat universitas'],
                                    ] as [$preset, $desc])
                                    <button type="button"
                                        class="btn btn-sm btn-outline-primary preset-btn"
                                        data-name="{{ $preset }}"
                                        data-desc="{{ $desc }}">
                                        {{ $preset }}
                                    </button>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary d-flex align-items-center gap-2">
                                <i data-feather="save" style="width:15px;height:15px;"></i>
                                Simpan Role
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Auto-generate slug dari nama
document.getElementById('name').addEventListener('input', function () {
    const slugField = document.getElementById('slug');
    if (!slugField.dataset.manual) {
        slugField.value = this.value
            .toLowerCase()
            .trim()
            .replace(/[^a-z0-9\s-]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-');
    }
});

document.getElementById('slug').addEventListener('input', function () {
    this.dataset.manual = this.value ? 'true' : '';
});

// Preset buttons
document.querySelectorAll('.preset-btn').forEach(btn => {
    btn.addEventListener('click', function () {
        const name = this.dataset.name;
        const desc = this.dataset.desc;
        document.getElementById('name').value = name;
        document.getElementById('description').value = desc;
        // Trigger slug generation
        document.getElementById('name').dispatchEvent(new Event('input'));
        document.querySelector('[name="slug"]').dataset.manual = '';
    });
});
</script>
@endpush
@endsection
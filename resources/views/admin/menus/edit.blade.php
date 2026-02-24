@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">Edit Menu</h2>

    <form action="{{ route('admin.menus.update', $menu->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Menu Name</label>
            <input type="text"
                   name="name"
                   class="form-control"
                   value="{{ old('name', $menu->name) }}"
                   required>
        </div>

        <div class="mb-3">
            <label class="form-label">Parent Menu</label>
            <select name="parent_id" class="form-select">
                <option value="">-- None (Parent Menu) --</option>
                @foreach($menus as $parent)
                    <option value="{{ $parent->id }}"
                        {{ $menu->parent_id == $parent->id ? 'selected' : '' }}>
                        {{ $parent->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Route Name</label>
            <input type="text"
                   name="route_name"
                   class="form-control"
                   value="{{ old('route_name', $menu->route_name) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Icon</label>
            <input type="text"
                   name="icon"
                   class="form-control"
                   value="{{ old('icon', $menu->icon) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Sort Order</label>
            <input type="number"
                   name="sort_order"
                   class="form-control"
                   value="{{ old('sort_order', $menu->sort_order) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Roles</label>
            @foreach($roles as $role)
                <div class="form-check">
                    <input class="form-check-input"
                           type="checkbox"
                           name="roles[]"
                           value="{{ $role->id }}"
                           {{ $menu->roles->contains($role->id) ? 'checked' : '' }}>
                    <label class="form-check-label">
                        {{ $role->name }}
                    </label>
                </div>
            @endforeach
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox"
                   name="is_active"
                   class="form-check-input"
                   {{ $menu->is_active ? 'checked' : '' }}>
            <label class="form-check-label">Active</label>
        </div>

        <button type="submit" class="btn btn-success">
            Update Menu
        </button>

        <a href="{{ route('admin.menus.index') }}" class="btn btn-secondary">
            Cancel
        </a>
    </form>
</div>
@endsection
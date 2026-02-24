@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">Create Menu</h2>

    <form action="{{ route('admin.menus.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Menu Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Parent Menu</label>
            <select name="parent_id" class="form-select">
                <option value="">-- None (Parent Menu) --</option>
                @foreach($menus as $parent)
                    <option value="{{ $parent->id }}">{{ $parent->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Route Name</label>
            <input type="text" name="route_name" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Icon (Feather)</label>
            <input type="text" name="icon" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Sort Order</label>
            <input type="number" name="sort_order" class="form-control" value="0">
        </div>

        <div class="mb-3">
            <label class="form-label">Roles</label>
            @foreach($roles as $role)
                <div class="form-check">
                    <input class="form-check-input" type="checkbox"
                        name="roles[]" value="{{ $role->id }}">
                    <label class="form-check-label">
                        {{ $role->name }}
                    </label>
                </div>
            @endforeach
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" name="is_active" class="form-check-input" checked>
            <label class="form-check-label">Active</label>
        </div>

        <button type="submit" class="btn btn-success">
            Save Menu
        </button>

        <a href="{{ route('admin.menus.index') }}" class="btn btn-secondary">
            Cancel
        </a>
    </form>
</div>
@endsection
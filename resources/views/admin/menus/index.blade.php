@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Manage Menu</h2>
        <a href="{{ route('admin.menus.create') }}" class="btn btn-primary">
            + Add Menu
        </a>
    </div>

    <ul class="list-group">
        @forelse($menus as $menu)
            @include('admin.menus.partials.menu-item', ['menu' => $menu])
        @empty
            <li class="list-group-item text-muted">
                No menus found.
            </li>
        @endforelse
    </ul>
</div>
@endsection
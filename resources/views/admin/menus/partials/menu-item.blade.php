<li class="list-group-item">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <strong>{{ $menu->name }}</strong>
            @if(!$menu->is_active)
                <span class="badge bg-danger ms-2">Inactive</span>
            @endif
        </div>

        <div>
            <a href="{{ route('admin.menus.edit', $menu->id) }}" 
               class="btn btn-sm btn-warning">
               Edit
            </a>

            <form action="{{ route('admin.menus.destroy', $menu->id) }}" 
                  method="POST" 
                  class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="btn btn-sm btn-danger"
                        onclick="return confirm('Delete this menu?')">
                    Delete
                </button>
            </form>
        </div>
    </div>

    @if($menu->children->count())
        <ul class="list-group mt-2 ms-4">
            @foreach($menu->children as $child)
                @include('admin.menus.partials.menu-item', ['menu' => $child])
            @endforeach
        </ul>
    @endif
</li>
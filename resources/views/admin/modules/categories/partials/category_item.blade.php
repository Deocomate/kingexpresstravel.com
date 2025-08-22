<li class="dd-item" data-id="{{ $item['id'] }}">
    <div class="dd-content">
        <div class="dd-handle">
            <i class="fas fa-grip-vertical handle-icon"></i>
        </div>
        <div class="dd-text">
            <span class="category-name">{{ $item['name'] }}</span>
            <span class="badge {{ $item['type'] === 'TOUR' ? 'badge-info' : 'badge-warning' }} ml-2">{{ $item['type'] }}</span>
            <span class="badge {{ $item['is_active'] ? 'badge-success' : 'badge-danger' }} ml-1">{{ $item['is_active'] ? 'Hoạt động' : 'Ẩn' }}</span>
        </div>
        <div class="category-actions">
            <a href="{{ route('admin.categories.edit', ['category' => $item['id']]) }}" class="btn btn-xs btn-warning" title="Sửa">
                <i class="fas fa-edit"></i>
            </a>
            <form action="{{ route('admin.categories.destroy', ['category' => $item['id']]) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-xs btn-danger" title="Xóa"
                        onclick="return confirm('Bạn có chắc chắn muốn xóa mục này? Các danh mục con (nếu có) cũng sẽ bị xóa.')">
                    <i class="fas fa-trash"></i>
                </button>
            </form>
        </div>
    </div>

    @if (!empty($item['children']) && count($item['children']) > 0)
        <ol class="dd-list">
            @foreach ($item['children'] as $child)
                @include('admin.modules.categories.partials.category_item', ['item' => $child])
            @endforeach
        </ol>
    @endif
</li>

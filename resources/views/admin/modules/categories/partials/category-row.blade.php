<tr data-id="{{ $category->id }}" @if($category->parent_id) data-parent-id="{{ $category->parent_id }}"
    class="category-child" @endif>
    <td>{{ $category->id }}</td>
    <td>
        <span style="padding-left: {{ $level * 25 }}px;">
            @if($category->children->isNotEmpty())
                <a href="#" class="toggle-children mr-2"
                   style="text-decoration: none; width: 16px; display: inline-block;">
                    <i class="far fa-plus-square text-primary"></i>
                </a>
            @else
                <span class="indent-placeholder mr-2" style="display: inline-block; width: 16px;"></span>
            @endif
            {{ $category->name }}
        </span>
    </td>
    <td>
        @if($category->thumbnail)
            <img src="{{ url($category->thumbnail) }}" alt="{{ $category->name }}"
                 style="width: 80px; height: 60px; object-fit: cover;">
        @endif
    </td>
    <td>
        <span class="badge {{ $category->type === 'TOUR' ? 'badge-info' : 'badge-warning' }}">
            {{ $category->type }}
        </span>
    </td>
    <td>{{ $category->priority }}</td>
    <td>
        <span class="badge {{ $category->is_active ? 'badge-success' : 'badge-danger' }}">
            {{ $category->is_active ? 'Hoạt động' : 'Không hoạt động' }}
        </span>
    </td>
    <td class="text-nowrap">
        <a class="btn btn-warning btn-sm"
           href="{{ route('admin.categories.edit', ['category' => $category->id]) }}">
            <i class="fas fa-edit"></i> Sửa
        </a>
        <form action="{{ route('admin.categories.destroy', ['category' => $category->id]) }}"
              method="POST" class="d-inline-block">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger btn-sm"
                    onclick="return confirm('Bạn có chắc muốn xóa Danh mục này? Thao tác này sẽ xóa cả các danh mục con.')">
                <i class="fas fa-trash"></i> Xoá
            </button>
        </form>
    </td>
</tr>

@if ($category->children->isNotEmpty())
    @foreach ($category->children as $child)
        @include('admin.modules.categories.partials.category-row', ['category' => $child, 'level' => $level + 1])
    @endforeach
@endif

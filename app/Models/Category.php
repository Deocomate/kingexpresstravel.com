<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $name
 * @property string|null $thumbnail
 * @property string $slug
 * @property int $priority
 * @property bool $is_active
 * @property int|null $parent_id
 * @property string $type
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Category|null $parent
 * @property-read Collection<int, Category> $children
 * @property-read Collection<int, Category> $recursiveChildren
 * @method static Builder|Category newModelQuery()
 * @method static Builder|Category newQuery()
 * @method static Builder|Category query()
 * @method static Builder|Category where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static Category|null find($id, $columns = ['*'])
 * @method static Category create(array $attributes = [])
 */
class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'thumbnail',
        'slug',
        'priority',
        'is_active',
        'parent_id',
        'type',
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id')->orderBy('priority');
    }

    /** @noinspection PhpUnused */
    public function recursiveChildren(): HasMany
    {
        return $this->children()->with('recursiveChildren');
    }
}

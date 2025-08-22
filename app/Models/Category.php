<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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
 * @property-read Collection<int, Tour> $tours
 * @property-read Collection<int, News> $news
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

    public function recursiveChildren(): HasMany
    {
        return $this->children()->with('recursiveChildren');
    }

    public function tours(): BelongsToMany
    {
        return $this->belongsToMany(Tour::class, 'tour_categories');
    }

    public function news(): HasMany
    {
        return $this->hasMany(News::class);
    }

    public function getAllDescendantIds(): array
    {
        $ids = [$this->id];
        foreach ($this->children as $child) {
            $ids = array_merge($ids, $child->getAllDescendantIds());
        }
        return $ids;
    }
}

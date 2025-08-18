<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string|null $title
 * @property int $category_id
 * @property string $slug
 * @property string|null $thumbnail
 * @property int|null $priority
 * @property int $view
 * @property string|null $short_description
 * @property string|null $contents
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder<static>|News newModelQuery()
 * @method static Builder<static>|News newQuery()
 * @method static Builder<static>|News query()
 * @method static Builder<static>|News whereCategoryId($value)
 * @method static Builder<static>|News whereContents($value)
 * @method static Builder<static>|News whereCreatedAt($value)
 * @method static Builder<static>|News whereId($value)
 * @method static Builder<static>|News wherePriority($value)
 * @method static Builder<static>|News whereShortDescription($value)
 * @method static Builder<static>|News whereSlug($value)
 * @method static Builder<static>|News whereThumbnail($value)
 * @method static Builder<static>|News whereTitle($value)
 * @method static Builder<static>|News whereUpdatedAt($value)
 * @method static Builder<static>|News whereView($value)
 * @mixin Eloquent
 */
class News extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'category_id',
        'slug',
        'thumbnail',
        'priority',
        'view',
        'short_description',
        'contents',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}

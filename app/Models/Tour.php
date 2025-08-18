<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string|null $tour_code
 * @property string|null $name
 * @property string|null $duration
 * @property string|null $departure_point
 * @property int|null $remaining_slots
 * @property int|null $price_adult
 * @property int|null $price_child
 * @property int|null $price_toddler
 * @property int|null $price_infant
 * @property string|null $transport_mode
 * @property string|null $short_description
 * @property string|null $tour_description
 * @property int|null $priority
 * @property string|null $tour_schedule
 * @property string|null $thumbnail
 * @property string|null $images
 * @property string $slug
 * @property string|null $services_note
 * @property string|null $note
 * @property string|null $characteristic
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, Category> $categories
 * @property-read Collection<int, Destination> $destinations
 * @method static Builder|Tour newModelQuery()
 * @method static Builder|Tour newQuery()
 * @method static Builder|Tour query()
 * @mixin Eloquent
 */
class Tour extends Model
{
    use HasFactory;

    protected $fillable = [
        'tour_code',
        'name',
        'slug',
        'duration',
        'departure_point',
        'remaining_slots',
        'price_adult',
        'price_child',
        'price_toddler',
        'price_infant',
        'transport_mode',
        'short_description',
        'tour_description',
        'priority',
        'tour_schedule',
        'thumbnail',
        'images',
        'services_note',
        'note',
        'characteristic',
    ];

    protected $casts = [
        'images' => 'array',
        'tour_schedule' => 'array',
    ];

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'tour_categories');
    }

    public function destinations(): BelongsToMany
    {
        return $this->belongsToMany(Destination::class, 'tour_destinations')
            ->withPivot('position')
            ->orderBy('pivot_position');
    }
}

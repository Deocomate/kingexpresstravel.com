<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
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
 * @method static Builder<static>|Tour newModelQuery()
 * @method static Builder<static>|Tour newQuery()
 * @method static Builder<static>|Tour query()
 * @method static Builder<static>|Tour whereCharacteristic($value)
 * @method static Builder<static>|Tour whereCreatedAt($value)
 * @method static Builder<static>|Tour whereDeparturePoint($value)
 * @method static Builder<static>|Tour whereDuration($value)
 * @method static Builder<static>|Tour whereId($value)
 * @method static Builder<static>|Tour whereImages($value)
 * @method static Builder<static>|Tour whereName($value)
 * @method static Builder<static>|Tour whereNote($value)
 * @method static Builder<static>|Tour wherePriceAdult($value)
 * @method static Builder<static>|Tour wherePriceChild($value)
 * @method static Builder<static>|Tour wherePriceInfant($value)
 * @method static Builder<static>|Tour wherePriceToddler($value)
 * @method static Builder<static>|Tour wherePriority($value)
 * @method static Builder<static>|Tour whereRemainingSlots($value)
 * @method static Builder<static>|Tour whereServicesNote($value)
 * @method static Builder<static>|Tour whereShortDescription($value)
 * @method static Builder<static>|Tour whereSlug($value)
 * @method static Builder<static>|Tour whereThumbnail($value)
 * @method static Builder<static>|Tour whereTourCode($value)
 * @method static Builder<static>|Tour whereTourDescription($value)
 * @method static Builder<static>|Tour whereTourSchedule($value)
 * @method static Builder<static>|Tour whereTransportMode($value)
 * @method static Builder<static>|Tour whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Tour extends Model
{
    //
}

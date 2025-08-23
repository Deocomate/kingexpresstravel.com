<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int|null $user_id
 * @property string|null $full_name
 * @property string|null $email
 * @property string|null $phone
 * @property string|null $address
 * @property int $tour_id
 * @property Carbon|null $departure_date
 * @property int $adult_quantity
 * @property int $child_quantity
 * @property int $toddler_quantity
 * @property int $infant_quantity
 * @property int|null $total_price
 * @property string $status
 * @property string|null $note
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read User|null $user
 * @property-read Tour|null $tour
 * @property-read Payment|null $payment
 * @method static Builder|Order newModelQuery()
 * @method static Builder|Order newQuery()
 * @method static Builder|Order query()
 * @mixin Eloquent
 */
class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'full_name',
        'email',
        'phone',
        'address',
        'tour_id',
        'departure_date',
        'adult_quantity',
        'child_quantity',
        'toddler_quantity',
        'infant_quantity',
        'total_price',
        'status',
        'note',
    ];

    protected $casts = [
        'departure_date' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tour(): BelongsTo
    {
        return $this->belongsTo(Tour::class);
    }

    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }
}

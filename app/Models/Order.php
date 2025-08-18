<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int|null $user_id
 * @property string|null $full_name
 * @property string|null $email
 * @property string|null $phone
 * @property int $tour_id
 * @property int $adult_quantity
 * @property int $child_quantity
 * @property int $toddler_quantity
 * @property int $infant_quantity
 * @property int|null $total_price
 * @property string $status
 * @property string|null $note
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder<static>|Order newModelQuery()
 * @method static Builder<static>|Order newQuery()
 * @method static Builder<static>|Order query()
 * @method static Builder<static>|Order whereAdultQuantity($value)
 * @method static Builder<static>|Order whereChildQuantity($value)
 * @method static Builder<static>|Order whereCreatedAt($value)
 * @method static Builder<static>|Order whereEmail($value)
 * @method static Builder<static>|Order whereFullName($value)
 * @method static Builder<static>|Order whereId($value)
 * @method static Builder<static>|Order whereInfantQuantity($value)
 * @method static Builder<static>|Order whereNote($value)
 * @method static Builder<static>|Order wherePhone($value)
 * @method static Builder<static>|Order whereStatus($value)
 * @method static Builder<static>|Order whereToddlerQuantity($value)
 * @method static Builder<static>|Order whereTotalPrice($value)
 * @method static Builder<static>|Order whereTourId($value)
 * @method static Builder<static>|Order whereUpdatedAt($value)
 * @method static Builder<static>|Order whereUserId($value)
 * @mixin Eloquent
 */
class Order extends Model
{
    //
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string|null $name
 * @property string|null $description
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Destination newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Destination newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Destination query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Destination whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Destination whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Destination whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Destination whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Destination whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Destination whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Destination extends Model
{
    //
}

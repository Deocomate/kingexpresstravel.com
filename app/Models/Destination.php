<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string|null $name
 * @property string|null $description
 * @property string $slug
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder<static>|Destination newModelQuery()
 * @method static Builder<static>|Destination newQuery()
 * @method static Builder<static>|Destination query()
 * @method static Builder<static>|Destination whereCreatedAt($value)
 * @method static Builder<static>|Destination whereDescription($value)
 * @method static Builder<static>|Destination whereId($value)
 * @method static Builder<static>|Destination whereName($value)
 * @method static Builder<static>|Destination whereSlug($value)
 * @method static Builder<static>|Destination whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Destination extends Model
{
    //
}

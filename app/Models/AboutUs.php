<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string|null $title
 * @property string $slug
 * @property string|null $content
 * @property int $view
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder<static>|AboutUs newModelQuery()
 * @method static Builder<static>|AboutUs newQuery()
 * @method static Builder<static>|AboutUs query()
 * @method static Builder<static>|AboutUs whereContent($value)
 * @method static Builder<static>|AboutUs whereCreatedAt($value)
 * @method static Builder<static>|AboutUs whereId($value)
 * @method static Builder<static>|AboutUs whereSlug($value)
 * @method static Builder<static>|AboutUs whereTitle($value)
 * @method static Builder<static>|AboutUs whereUpdatedAt($value)
 * @method static Builder<static>|AboutUs whereView($value)
 * @mixin Eloquent
 */
class AboutUs extends Model
{
    //
}

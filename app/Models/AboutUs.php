<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string|null $title
 * @property string $slug
 * @property string|null $content
 * @property int $view
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AboutUs newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AboutUs newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AboutUs query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AboutUs whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AboutUs whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AboutUs whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AboutUs whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AboutUs whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AboutUs whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AboutUs whereView($value)
 * @mixin \Eloquent
 */
class AboutUs extends Model
{
    //
}

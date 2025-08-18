<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string|null $company_name
 * @property string|null $email
 * @property string|null $phone
 * @property string|null $facebook
 * @property string|null $zalo
 * @property string|null $working_hours
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder<static>|Contact newModelQuery()
 * @method static Builder<static>|Contact newQuery()
 * @method static Builder<static>|Contact query()
 * @method static Builder<static>|Contact whereCompanyName($value)
 * @method static Builder<static>|Contact whereCreatedAt($value)
 * @method static Builder<static>|Contact whereEmail($value)
 * @method static Builder<static>|Contact whereFacebook($value)
 * @method static Builder<static>|Contact whereId($value)
 * @method static Builder<static>|Contact wherePhone($value)
 * @method static Builder<static>|Contact whereUpdatedAt($value)
 * @method static Builder<static>|Contact whereWorkingHours($value)
 * @method static Builder<static>|Contact whereZalo($value)
 * @mixin Eloquent
 */
class Contact extends Model
{
    //
}

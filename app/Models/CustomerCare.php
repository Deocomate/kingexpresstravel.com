<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string|null $full_name
 * @property string|null $email
 * @property string|null $phone
 * @property string|null $subject
 * @property string|null $message
 * @property string|null $note
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CustomerCare newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CustomerCare newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CustomerCare query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CustomerCare whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CustomerCare whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CustomerCare whereFullName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CustomerCare whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CustomerCare whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CustomerCare whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CustomerCare wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CustomerCare whereSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CustomerCare whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CustomerCare extends Model
{
    //
}

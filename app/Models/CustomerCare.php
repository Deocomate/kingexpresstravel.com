<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string|null $full_name
 * @property string|null $email
 * @property string|null $phone
 * @property string|null $subject
 * @property string|null $message
 * @property string|null $note
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder<static>|CustomerCare newModelQuery()
 * @method static Builder<static>|CustomerCare newQuery()
 * @method static Builder<static>|CustomerCare query()
 * @method static Builder<static>|CustomerCare whereCreatedAt($value)
 * @method static Builder<static>|CustomerCare whereEmail($value)
 * @method static Builder<static>|CustomerCare whereFullName($value)
 * @method static Builder<static>|CustomerCare whereId($value)
 * @method static Builder<static>|CustomerCare whereMessage($value)
 * @method static Builder<static>|CustomerCare whereNote($value)
 * @method static Builder<static>|CustomerCare wherePhone($value)
 * @method static Builder<static>|CustomerCare whereSubject($value)
 * @method static Builder<static>|CustomerCare whereUpdatedAt($value)
 * @mixin Eloquent
 */
class CustomerCare extends Model
{
    protected $fillable = [
        'full_name',
        'email',
        'phone',
        'subject',
        'message',
        'note',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $contact_id
 * @property string|null $branch_name
 * @property string|null $address
 * @property string|null $phone
 * @property string|null $email
 * @property int $is_main
 * @property string|null $working_hours
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContactBranch newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContactBranch newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContactBranch query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContactBranch whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContactBranch whereBranchName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContactBranch whereContactId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContactBranch whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContactBranch whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContactBranch whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContactBranch whereIsMain($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContactBranch wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContactBranch whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContactBranch whereWorkingHours($value)
 * @mixin \Eloquent
 */
class ContactBranch extends Model
{
    //
}

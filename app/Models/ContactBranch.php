<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $contact_id
 * @property string|null $branch_name
 * @property string|null $address
 * @property string|null $phone
 * @property string|null $email
 * @property int $is_main
 * @property string|null $working_hours
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder<static>|ContactBranch newModelQuery()
 * @method static Builder<static>|ContactBranch newQuery()
 * @method static Builder<static>|ContactBranch query()
 * @method static Builder<static>|ContactBranch whereAddress($value)
 * @method static Builder<static>|ContactBranch whereBranchName($value)
 * @method static Builder<static>|ContactBranch whereContactId($value)
 * @method static Builder<static>|ContactBranch whereCreatedAt($value)
 * @method static Builder<static>|ContactBranch whereEmail($value)
 * @method static Builder<static>|ContactBranch whereId($value)
 * @method static Builder<static>|ContactBranch whereIsMain($value)
 * @method static Builder<static>|ContactBranch wherePhone($value)
 * @method static Builder<static>|ContactBranch whereUpdatedAt($value)
 * @method static Builder<static>|ContactBranch whereWorkingHours($value)
 * @mixin Eloquent
 */
class ContactBranch extends Model
{
    //
}

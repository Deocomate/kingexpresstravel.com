<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
 * @property-read Collection<int, ContactBranch> $branches
 * @method static Builder|Contact newModelQuery()
 * @method static Builder|Contact newQuery()
 * @method static Builder|Contact query()
 * @method static Contact|null find($id, $columns = ['*'])
 * @method static Contact findOrFail($id, $columns = ['*'])
 * @method static Contact firstOrCreate(array $attributes, array $values = [])
 * @method static Contact firstOrNew(array $attributes, array $values = [])
 * @method static Contact updateOrCreate(array $attributes, array $values = [])
 * @method static Builder|Contact whereId($value)
 * @method static Builder|Contact whereCompanyName($value)
 * @method static Builder|Contact whereEmail($value)
 * @method static Builder|Contact wherePhone($value)
 * @method static Builder|Contact whereFacebook($value)
 * @method static Builder|Contact whereZalo($value)
 * @method static Builder|Contact whereWorkingHours($value)
 * @method static Builder|Contact whereCreatedAt($value)
 * @method static Builder|Contact whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Contact extends Model
{
    use HasFactory;

    protected $table = 'contacts';

    protected $fillable = [
        'company_name',
        'email',
        'phone',
        'facebook',
        'zalo',
        'working_hours',
    ];


    public function branches(): HasMany
    {
        return $this->hasMany(ContactBranch::class);
    }
}

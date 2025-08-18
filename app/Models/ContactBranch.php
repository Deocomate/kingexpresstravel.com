<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $contact_id
 * @property string|null $branch_name
 * @property string|null $address
 * @property string|null $phone
 * @property string|null $email
 * @property boolean $is_main
 * @property string|null $working_hours
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Contact $contact
 * @method static Builder|ContactBranch newModelQuery()
 * @method static Builder|ContactBranch newQuery()
 * @method static Builder|ContactBranch query()
 * @method static ContactBranch|null find($id, $columns = ['*'])
 * @method static ContactBranch findOrFail($id, $columns = ['*'])
 * @method static ContactBranch firstOrCreate(array $attributes, array $values = [])
 * @method static ContactBranch firstOrNew(array $attributes, array $values = [])
 * @method static ContactBranch updateOrCreate(array $attributes, array $values = [])
 * @method static Builder|ContactBranch whereId($value)
 * @method static Builder|ContactBranch whereContactId($value)
 * @method static Builder|ContactBranch whereBranchName($value)
 * @method static Builder|ContactBranch whereAddress($value)
 * @method static Builder|ContactBranch wherePhone($value)
 * @method static Builder|ContactBranch whereEmail($value)
 * @method static Builder|ContactBranch whereIsMain($value)
 * @method static Builder|ContactBranch whereWorkingHours($value)
 * @method static Builder|ContactBranch whereCreatedAt($value)
 * @method static Builder|ContactBranch whereUpdatedAt($value)
 * @mixin Eloquent
 */
class ContactBranch extends Model
{
    use HasFactory;

    protected $table = 'contact_branches';

    protected $fillable = [
        'contact_id',
        'branch_name',
        'address',
        'phone',
        'email',
        'is_main',
        'working_hours',
    ];

    protected $casts = [
        'is_main' => 'boolean',
    ];

    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class);
    }
}

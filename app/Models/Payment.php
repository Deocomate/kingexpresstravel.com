<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $order_id
 * @property string|null $method
 * @property string|null $transaction_id
 * @property int|null $amount
 * @property string $status
 * @property Carbon|null $paid_at
 * @property string|null $note
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder<static>|Payment newModelQuery()
 * @method static Builder<static>|Payment newQuery()
 * @method static Builder<static>|Payment query()
 * @method static Builder<static>|Payment whereAmount($value)
 * @method static Builder<static>|Payment whereCreatedAt($value)
 * @method static Builder<static>|Payment whereId($value)
 * @method static Builder<static>|Payment whereMethod($value)
 * @method static Builder<static>|Payment whereNote($value)
 * @method static Builder<static>|Payment whereOrderId($value)
 * @method static Builder<static>|Payment wherePaidAt($value)
 * @method static Builder<static>|Payment whereStatus($value)
 * @method static Builder<static>|Payment whereTransactionId($value)
 * @method static Builder<static>|Payment whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Payment extends Model
{
    protected $fillable = [
        'order_id',
        'method',
        'transaction_id',
        'amount',
        'status',
        'paid_at',
        'note',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
    ];
}

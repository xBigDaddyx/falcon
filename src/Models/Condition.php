<?php

namespace Xbigdaddyx\Falcon\Models;

use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Wildside\Userstamps\Userstamps;

class Condition extends Model
{
    use HasFactory, SoftDeletes, Userstamps, HasUuids;
    protected $primaryKey = 'uuid';
    protected $table = 'falcon_conditions';

    protected $fillable = [
        'name',
        'description',
        'icon',
        'color',
        'deleted_at',
        'deleted_by',
        'created_by',
        'updated_by',
    ];
    public function inventories(): HasMany
    {
        return $this->hasMany(Inventory::class, 'condition_id', 'uuid');
    }
}

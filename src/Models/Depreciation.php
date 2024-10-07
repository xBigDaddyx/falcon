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
use Xbigdaddyx\Falcon\Events\MethodAssigned;

class Depreciation extends Model
{
    use HasFactory, SoftDeletes, Userstamps, HasUuids;
    protected $primaryKey = 'asset_id';
    protected $table = 'falcon_depreciations';
    public static function boot()
    {
        parent::boot();
        Model::shouldBeStrict();
        static::created(function ($model) {
            event(new MethodAssigned($model->asset_id, $model->method_id));
        });
    }
    protected $fillable = [
        'asset_id',
        'method_id',
        'deleted_at',
        'deleted_by',
        'created_by',
        'updated_by',
    ];
    public function bookValues(): HasMany
    {
        return $this->hasMany(BookValue::class, 'depreciation_id');
    }
    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class, 'asset_id', 'uuid');
    }
    public function method(): BelongsTo
    {
        return $this->belongsTo(Method::class, 'method_id', 'uuid');
    }
}

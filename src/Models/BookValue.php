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

class BookValue extends Model
{
    use HasFactory, SoftDeletes, Userstamps, HasUuids;
    protected $primaryKey = 'uuid';
    protected $table = 'falcon_book_values';
    public static function boot()
    {
        parent::boot();
        Model::shouldBeStrict();
    }
    protected $fillable = [
        'depreciation_id',
        'value',
        'period',
        'book_value',
        'deleted_at',
        'deleted_by',
        'created_by',
        'updated_by',
    ];
    public function depreciation(): BelongsTo
    {
        return $this->belongsTo(Depreciation::class);
    }
}

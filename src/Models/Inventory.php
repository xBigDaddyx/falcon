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

class Inventory extends Model
{
    use HasFactory, SoftDeletes, Userstamps, HasUuids;
    protected $primaryKey = 'uuid';
    protected $table = 'falcon_inventories';
    public static function boot()
    {
        parent::boot();
        Model::shouldBeStrict();
    }
    protected $fillable = [
        'category_id',
        'sub_category_id',
        'pictures',
        'model',
        'manufacture_id',
        'specifications',
        'serial',
        'name',
        'condition_id',
        'status_id',
        'asset_id',
        'deleted_at',
        'deleted_by',
        'created_by',
        'updated_by',
    ];
    protected $casts = [
        'pictures' => 'array',
        'specifications' => 'array',
    ];
    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class, 'asset_id', 'uuid');
    }
    public function condition(): BelongsTo
    {
        return $this->belongsTo(Condition::class, 'condition_id', 'uuid');
    }
    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class, 'status_id', 'uuid');
    }
    public function subCategory(): BelongsTo
    {
        return $this->belongsTo(SubCategory::class, 'sub_category_id', 'uuid');
    }
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'uuid');
    }
    public function manufacture(): BelongsTo
    {
        return $this->belongsTo(Manufacture::class, 'manufacture_id', 'uuid');
    }
}

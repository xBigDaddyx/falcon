<?php

namespace Xbigdaddyx\Falcon\Models;

use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Wildside\Userstamps\Userstamps;
use Xbigdaddyx\Fuse\Domain\Company\Models\Company;
use Xbigdaddyx\Fuse\Domain\User\Models\User;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Asset extends Model
{
    use HasFactory, SoftDeletes, Userstamps, HasUuids;
    protected $primaryKey = 'uuid';
    protected $table = 'falcon_assets';
    public static function boot()
    {
        parent::boot();
        Model::shouldBeStrict();
        static::creating(function ($model) {
            $model->company_id = Auth::user()->company_id;
        });
    }

    protected $fillable = [
        'asset_name',
        'category_id',
        'sub_category_id',
        'asset_code',
        'purchased_price',
        'purchased_at',
        'purchase_order',
        'attachment',
        'company_id',
        'deleted_at',
        'deleted_by',
        'created_by',
        'updated_by',
    ];
    public function getBookValueAttribute()
    {
        if ($this->has('depreciation')->exists()) {
            return $this->depreciation->bookValues()->where('depreciation_id', $this->uuid)->latest()->first()->book_value;
        }
        return 0;
    }
    // public function location(): BelongsTo
    // {
    //     return $this->belongsTo(Location::class, 'location_id', 'uuid');
    // }
    public function methods(): BelongsToMany
    {
        return $this->belongsToMany(Method::class, 'falcon_depreciations', 'asset_id', 'method_id')->withTimestamps();
    }
    public function inventories(): HasMany
    {
        return $this->hasMany(Inventory::class, 'asset_id');
    }
    public function age(): BelongsTo
    {
        return $this->belongsTo(Age::class, 'age_id', 'uuid');
    }
    public function depreciation(): HasOne
    {
        return $this->hasOne(Depreciation::class, 'asset_id');
    }
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'falcon_user_has_assets', 'asset_id', 'user_id',);
    }
    public function subCategory(): BelongsTo
    {
        return $this->belongsTo(SubCategory::class, 'sub_category_id', 'uuid');
    }
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'uuid');
    }
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}

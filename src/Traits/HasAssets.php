<?php

namespace Xbigdaddyx\Falcon\Traits;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Xbigdaddyx\Falcon\Models\Asset;

trait HasAssets
{
    public function assets(): BelongsToMany
    {
        return $this->belongsToMany(Asset::class, 'falcon_user_has_assets', 'user_id', 'asset_id')->withTimestamps();
    }
}

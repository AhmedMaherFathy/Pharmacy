<?php

namespace Modules\Auth\Traits;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Modules\Auth\Helpers\UserHelper;

trait AuthTrait
{
    public function scopeWhereValidType(Builder $builder, bool $inMobile)
    {
        return $builder
            ->when(! $inMobile, fn ($query) => $query->whereIn('type', UserHelper::nonMobileTypes()))
            ->when($inMobile, fn ($query) => $query->whereNotIn('type', UserHelper::nonMobileTypes()));
    }
}

<?php
namespace App\Models\Traits;
use App\Models\Scopes\BelongsToAgencyScope;
use Illuminate\Database\Eloquent\Model;

trait BelongsToAgency {
    protected static function bootBelongsToAgency() {
        static::addGlobalScope(new BelongsToAgencyScope);
        static::creating(function (Model $model) {
            if (app()->bound('currentAgency') && $agency = app('currentAgency')) {
                $model->agency_id = $agency->id;
            }
        });
    }
}

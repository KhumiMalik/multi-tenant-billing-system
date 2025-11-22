<?php
namespace App\Models\Scopes;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class BelongsToAgencyScope implements Scope {
    public function apply(Builder $builder, Model $model) {
        if (app()->bound('currentAgency') && $agency = app('currentAgency')) {
            $builder->where($model->getTable().'.agency_id', $agency->id);
        }
    }
}

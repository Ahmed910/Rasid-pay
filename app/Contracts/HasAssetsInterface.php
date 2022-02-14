<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Http\Request;

interface HasAssetsInterface
{
    /**
     * add morphMany relationship for media
     *
     */
    public function images(): MorphMany;

    /**
     * save the assets of current model
     *
     * @param Illuminate\Database\Eloquent\Model  $model
     * @param Illuminate\Http\Request $request
     *
     * @return void
     */
    public function saveAssets(Model $model, Request $request): void;
}

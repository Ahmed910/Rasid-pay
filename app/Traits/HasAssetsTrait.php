<?php

namespace App\Traits;

use App\Models\AppMedia;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait HasAssetsTrait
{
    public static function booting()
    {
        static::deleted(function (self $self) {
            $self->deleteAssets($self);
        });
    }

    private function saveAsset($model, Request $request, string $key)
    {
        $new = $request->{$key};
        $old = $model->images()->whereOption($key)?->first();

        if (!empty($old) && $request->hasFile("$key")) {
            $path = Str::replace("/storage/", "", $old->media);
            Storage::delete($path);
        }

        if ($new && is_file($new)) {
            $path = $request->file("$key")->storePublicly(
                (string) Str::of(get_class($model))
                    ->afterLast("\\")
                    ->lower()
                    ->plural()
            );

            $image =  '/storage/' . $path;
            $model->images()->create([
                "media"  =>  $image,
                "option" => $key
            ]);
        }
    }

    public  function saveAssets($model, Request $request): void
    {
        //TODO:: how we can save array of images by one request
        if (method_exists($model, "images") && property_exists($model, "assets")) {
            foreach ($model->assets as $key) {
                $this->saveAsset($model, $request, $key);
            }
        }
    }

    private function deleteAssets($model)
    {
        if (method_exists($model, "images") && property_exists($model, "assets")) {
            foreach ($model->assets as $key) {
                if (!$model->forceDeleting)
                    $model->images()->whereOption($key)->delete();

                if ($model->forceDeleting) {
                    $media = $model->images()->whereOption($key)->first()?->media;
                    $path = Str::replace("/storage/", "", $media);
                    Storage::delete($path);

                    $model->images()->whereOption($key)->forceDelete();
                }
            }
        }
    }

    public function images(): MorphMany
    {
        return $this->morphMany(AppMedia::class, "mediable");
    }
}

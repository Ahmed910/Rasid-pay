<?php

namespace App\Traits;

use App\Models\AppMedia;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait HasAssetsTrait
{

    public static function bootHasAssetsTrait()
    {
        static::deleted(function (self $self) {
            $self->deleteAssets($self);
        });
    }

    private function saveAsset($model, Request $request, string $key, string $uploadPath)
    {
        $new = $request->{$key};
        $old = $model->images()->whereOption($key)?->first();

        if (!empty($old) && $request->hasFile("$key")) {
            $path = Str::replace($uploadPath, "", $old->media);
            Storage::delete($path);
        }

        if ($new && is_file($new)) {
            $path = $request->file("$key")->storePublicly($uploadPath);

            $image =  "/storage/" . $path;
            $model->images()->create([
                "media"  =>  $image,
                "option" => $key
            ]);
        }
    }

    public function deleteAsset(Model $model, string $propertyName, string $pathName)
    {
        foreach ($model->{$propertyName} as $key) {
            if (!$model->forceDeleting)
                $model->images()->whereOption($key)->delete();

            if ($model->forceDeleting) {
                $media = $model->images()->whereOption($key)->first()?->media;

                if (property_exists($model, $propertyName))
                    $path = Str::replace($pathName, "", $media);

                Storage::delete($path);

                $model->images()->whereOption($key)->forceDelete();
            }
        }
    }

    public  function saveAssets($model, Request $request): void
    {
        $uploadPath = (string) Str::of(class_basename($model))->lower()->plural();
        //TODO:: how we can save array of images by one request
        if (property_exists($model, "assets")) {
            foreach ($model->assets as $key) {
                $this->saveAsset($model, $request, $key, "/images/" . $uploadPath);
            }
        }
        if (property_exists($model, "files")) {
            foreach ($model->files as $key) {
                $this->saveAsset($model, $request, $key, "/files/" . $uploadPath);
            }
        }
    }

    private function deleteAssets($model)
    {
        if (property_exists($model, "assets")) {
            $this->deleteAsset($model, "assets", "/storage/");
        }

        if (property_exists($model, "files")) {
            $this->deleteAsset($model, "files", "/storage/");
        }
    }

    public function images(): MorphMany
    {
        return $this->morphMany(AppMedia::class, "mediable");
    }
}

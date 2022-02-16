# How To Use HasAssetsTrait

## 1- implements `HasAssetsInterface`

```php
use App\Contracts\HasAssetsInterface;

implements HasAssetsInterface
```


## 2- use `HasAssetsTrait` in Your Model 
```php
use App\Traits\HasAssetsTrait;

use HasAssetsTrait;
```

## 3- Add assets property 
in your model you should use `$assets` property that include every image key in your model 

```php
public $assets = ["image"];
```

### Notice : 
If you have files like (pdf , docx , ..) you can use `files` property to save them into `files/modelName(s)`

## 4- Finally Add this code in the top of your model 
```php 
    public static function boot()
    {
        parent::boot();
        static::saved(function ($model) {
            $model->saveAssets($model, request());
        });
    }
```

# How to Load Assets On Your Model
Add this property on your model 

```php 
public $with   = ["images"];
```

# Example
`App\Models\Department\Department.php`

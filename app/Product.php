<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    protected $fillable = ['product_name', 'product_price', 'product_quantity', 'alert_quantity', 'product_photo', 'category_id'];

    function relationtocategorytable()
    {
        return $this->hasOne('App\Category', 'id', 'category_id');
    }

    function relationToProductGalleryTable()
    {
        return $this->hasMany('App\ProductGallery', 'product_id', 'id');
    }
}

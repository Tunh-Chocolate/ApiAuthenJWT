<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/** Class products
 * @property string $products
 * @property string $sku
 * @property string $name
 * @property string $stock
 * @property string $avatar
 */
class Products extends Model
{
    use HasFactory;
    // class name & table name khác nhau
    protected $table='products';
    protected $primaryKey='id';
    protected $sku='sku';
    protected $name='name';
    protected $stock='stock';
    protected $avatar='avatar';
    
    protected $category_id='category_id';
    
   
   
    protected $fillable=['sku','name','stock','avatar','category_id'];

}

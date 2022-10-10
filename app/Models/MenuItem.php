<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{

    public function menuItems()
    {
        return $this->hasMany(MenuItem::class, 'parent_id');
    }

    public function childern(){
        return $this->hasMany(MenuItem::class, 'parent_id')->with('menuItems');
    }
}

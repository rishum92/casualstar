<?php

namespace App\Models;

use App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class MasterModel extends Model  {

   public static function newModel() {
      $className = get_called_class();
      $instantiateNew = new $className;
      return $instantiateNew;
    }

    public static function existingModel($id) {
      $className = get_called_class();
      $instantiateExisting = $className::find($id);
      return $instantiateExisting;
    }

    static function store($data) {
                $item = self::newModel();
      foreach($data as $key => $value) {
        $item->$key = $value;
      }
      if(Schema::hasColumn($item->getTable(), 'pos')){
        $item->pos = self::all()->max('pos') + 1;
      }
     
      $item->save();
      return $item;
    }

    static function updateField($id, $data) {
      $item = self::existingModel($id);
      if($data['key'] == 'description') {
        $data['value'] = str_replace("\n", '<br>', $data['value']);
      }
      $key = $data['key'];
      $value = $data['value'];
      $item->{$key} = $value;
      $item->save();
      return $item;
    }

    static function remove($id) {
      $item = self::existingModel($id);
      $item->delete();
      return $item;
    }

    public static function reorder($data) {
      foreach($data as $key => $item) {
          $item = self::existingModel($item['id']);
          if($item->user_id == Auth::user()->id) {
            $item->pos = $key;
            $item->save();
          }
      }
    }

}
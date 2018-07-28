<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
  /**
   * The table associated with the model.
   *
   * @var string
   */
   protected $fillable = array('author', 'text');

   protected $table = 'comments';
}

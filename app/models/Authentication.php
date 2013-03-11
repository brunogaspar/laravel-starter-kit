<?php

class Authentication extends Eloquent {

       protected $table = 'authentications';

       public function user()
       {
          return $this->belongsTo('User');
       }
}
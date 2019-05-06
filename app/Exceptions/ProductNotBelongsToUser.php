<?php

namespace App\Exceptions;

use Exception;

class ProductNotBelongsToUser extends Exception
{
    //
    public function render() {
        if($request->expectsJson()){
            return ['data'=>'product dont belongs to user'];
        }
        
    }
}

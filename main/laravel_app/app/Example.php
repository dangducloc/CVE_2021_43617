<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Example extends Model
{
    public function sayLMAO()
    {
        return view('lmao');
    }
}

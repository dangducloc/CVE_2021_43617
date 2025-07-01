<?php

namespace App\Http\Controllers;
use App\Example;
use Illuminate\Http\Request;

class ExampleController extends Controller
{
    public function index()
    {
        $example = new Example();
        return $example->sayLMAO(); // hoặc return view(...)
    }
    
}
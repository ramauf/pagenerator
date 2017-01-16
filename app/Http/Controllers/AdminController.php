<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Models\Cities;
class AdminController extends Controller{
    public function index($id = 0){
        echo $id;
        /*
        $tmp = Cities::all();
        foreach ($tmp as $t) var_dump($t->name);
        */
        //var_dump(Cities::getInfo(1));
        //var_dump($tmp->first()->name);
    }
}
<?php

namespace App\Http\Controllers;

use App\Http\Models\Users;
use Illuminate\Support\Facades\Session;

class IndexController extends Controller{
    //
    protected $mainTemplate = 'main';
    protected $templateData = [
        'subTemplate' => 'default',
        /*'isAuth' => false, */
        'menuName' => '',
        'meta' => ['title' => 'Поиск попутчиков', 'keywords' => 'поиск попутчиков', 'description' => 'На нашем сайте вы сможете найти попутчика практически в любом направлении по России']];
    public function __construct(){
        //$this->templateData['isAuth'] = Users::isAuth();
    }

    /*public function test(){
        //var_dump(bcrypt('werr'));
        if(Session::get('users.id') === null){
            //
        }
    }*/
}
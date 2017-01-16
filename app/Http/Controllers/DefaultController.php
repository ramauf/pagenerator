<?php

namespace App\Http\Controllers;

use App\Http\Requests;


class DefaultController extends IndexController
{
    public function index(){
        //$posts = Posts::getPosts();
        //$this->templateData['posts'] = $posts;
        //return view($this->mainTemplate, $this->templateData);
        $this->templateData['menuName'] = 'Главная';
        $this->templateData['subTemplate'] = 'default';
        return view($this->mainTemplate, $this->templateData);
    }
}

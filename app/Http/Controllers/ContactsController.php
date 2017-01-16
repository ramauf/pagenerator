<?php

namespace App\Http\Controllers;

//use App\Http\Models\Cities;
use App\Http\Models\Functions;
use App\Http\Models\Posts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Http\Requests;
//use Illuminate\Support\Facades\View;


class ContactsController extends IndexController
{
    public function index(){
        $this->templateData['subTemplate'] = 'pages.contacts';
        $this->templateData['menuName'] = 'Контакты';
        $this->templateData['sent'] = false;
        return view($this->mainTemplate, $this->templateData);
    }
}

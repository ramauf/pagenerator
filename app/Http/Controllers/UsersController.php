<?php

namespace App\Http\Controllers;
use App\Http\Models\Functions;
use Illuminate\Http\Request;
use App\Http\Models\Users;
use Mail;


class UsersController extends IndexController
{

    public function verification(Request $request, $code){
        if (empty($code)) exit;
        $this->templateData['subTemplate'] = 'emails.verification';
        $this->templateData['success'] = Users::checkVerification(['verification' => $code]);
        //var_dump($request->get->);
        //$this->templateData['postPages'] = $postPages;
        return view($this->mainTemplate, $this->templateData);
    }

    public function registration(Request $request){
        $this->templateData['subTemplate'] = 'users.registration';
        $this->templateData['menuName'] = 'Регистрация';
        if ($request->isMethod('post')){
            $result = Users::registration($request->all());
            if ($result['status']){
                $this->templateData['subTemplate'] = 'users.afterreg';
            }else{
                $this->templateData['messages'] = $result['errors'];
            }
        }
        $this->templateData['months'] = Functions::getMonths();
        return view($this->mainTemplate, $this->templateData);
        //redirect('/');


    }
    public function login(Request $request){
        if (Users::isAuth()) return redirect('/');
        $this->templateData['subTemplate'] = 'users.login';
        $this->templateData['menuName'] = 'Авторизация';
        if ($request->isMethod('post')) {
            $result = Users::login($request->all());
            if ($result['status']) {
                return redirect('/');
            } else {
                $this->templateData['messages'] = $result['errors'];
            }
        }
        return view($this->mainTemplate, $this->templateData);
    }
    public function logout(){
        Users::logout();
        return redirect('/');
    }
}

<?php

namespace App\Http\Models;

//use App\Http\Models\Cities;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
//use Illuminate\Http\RedirectResponse;

class Users extends Model
{
    protected $table = 'users';
    public $timestamps = false;
    protected $filable = [
        'firstName',
        'lastName',
        'email',
        'status',
        'type',
        'birthdate',
        'cities_id',
        'points_id',
        'verification'
    ];
    public static function checkVerification($data){
        $res = DB::select('SELECT * FROM `users` WHERE `verification` = ?', [$data['verification']]);
        if (empty($res)){
            return false;
        }else{
            DB::update('UPDATE `users` SET `verification` = "" WHERE `verification` = ?', [$data['verification']]);
            return true;
        }
    }
    public static function login($data){
        if (!isset($data['loginType'])) $data['loginType'] = 'byEmail';
        if ($data['loginType'] == 'byEmail'){
            if (!isset($data['email'])) $data['email'] = '';
            if (!isset($data['password'])) $data['password'] = '';
            $res = DB::select('SELECT * FROM `users` WHERE `email` = ? AND `password` = ? AND `verification` = ""', [$data['email'], md5($data['password'])]);
            if (!empty($res)){//Авторизация прошла
                Session::put('users', $res[0]);
                return ['status' => true, 'errors' => []];
            }else{//Авторизация не удалась
                return ['status' => false, 'errors' => ['emailorpass' => 'Неверный логин или пароль']];
            }
        }
        return ['status' => false, 'errors' => []];
    }
    public static function registration($data){
        if (!isset($data['registrationType'])) $data['registrationType'] = 'standart';
        if ($data['registrationType'] == 'standart'){
            if (!isset($data['firstName'])) $data['firstName'] = '';
            if (!isset($data['lastName'])) $data['lastName'] = '';
            if (!isset($data['email'])) $data['email'] = '';
            if (!isset($data['type'])) $data['type'] = '';
            if (!isset($data['birthdate'])) $data['birthdate'] = '';
            if (!isset($data['password'])) $data['password'] = '';
            if (!isset($data['password2'])) $data['password2'] = '';

            $validator = Validator::make([
                'firstName' => $data['firstName'],
                'lastName' => $data['lastName'],
                'email' => $data['email'],
                'type' => $data['type'],
                'birthdate' => $data['birthdate'],
                'password' => $data['password'],
                'password2' => $data['password2']
            ],[
                'firstName' => 'required',
                'lastName' => 'required',
                'email' => 'required|email',
                'type' => 'required|in:passenger,driver',
                'birthdate' => ['required', 'regex:/\d{4}\.\d+\.\d+/'],
                'password' => 'required|min:8',
                'password2' => 'required|min:8|same:password'
            ]);
            if ($validator->fails()){
                $mess = (array)$validator->messages();
                $mess = array_shift ($mess);
                return ['status' => false, 'errors' => [$mess, $validator->messages()->all(), $data]];
            }
            if ($validator->passes()){
                $birthdate = explode('.', $data['birthdate']);
                $birthdate = mktime(12, 30, 30, $birthdate[1], $birthdate[2], $birthdate[0]);
                $verification = md5($data['email'].microtime());
                Users::addRow([
                    'firstName' => $data['firstName'],
                    'lastName' => $data['lastName'],
                    'email' => $data['email'],
                    'status' => 'unverified',
                    'type' => $data['type'],
                    'birthdate' => $birthdate,
                    'password' => md5($data['password']),
                    'cities_id' => 0,
                    'points_id' => 0,
                    'verification' => $verification
                ]);

                Mail::send('emails.registration', ['url' => 'http://'.$_SERVER['HTTP_HOST'].'/verification/'.$verification], function($message) use ($data)
                {
                    $message->to($data['email'], $data['lastName'].' '.$data['firstName'])->subject('Welcome!');
                });
                return ['status' => true];
            }
        }
        return ['status' => false, 'errors' => []];
    }
    public static function logout(){
        if (Users::isAuth()) Session::forget('users');

    }
    public static function isAuth(){
        return isset(Session::get('users')->id);
    }

    public static function setStartPoints(){
        //Задает всем юзверям место жительства
        $users = DB::select('SELECT `id` FROM `users` WHERE `points_id` = 0 OR `cities_id` = 0');
        $points = DB::select('SELECT `id`, `cities_id` FROM `points` ORDER BY RAND() LIMIT '.sizeof($users));
        //var_dump($points[0]);exit;
        foreach ($users as $ind => $row){
            $row->points_id = $points[$ind]->id;
            $row->cities_id = $points[$ind]->cities_id;
            Users::addRow($row);
        }
    }

    public static function getUsers($condy = []){
        $limit = $addon = '';
        $orderType = 'id';
        $orderDirect = 'ASC';
        if (isset($condy['limit'])) $limit = 'LIMIT '.$condy['limit'];
        if (isset($condy['ids'])) $addon .= 'AND `id` IN('.implode(',', $condy['ids']).')';
        if (isset($condy['orderType'])) $orderType = $condy['orderType'];
        if (isset($condy['orderDirect'])) $orderDirect = $condy['orderDirect'];
        if (isset($condy['isRand'])){
            $orderType = 'RAND()';
            $orderDirect = '';
        }
        $users = DB::select('SELECT * FROM `users` WHERE 1 '.$addon.' ORDER BY '.$orderType.' '.$orderDirect.' '.$limit);
        $ids = [0];
        foreach ($users as $ind => $row){
            $ids[] = $row->id;
        }
        $votes = Votes::getVotes($ids);
        //var_dump($ids,$votes);
        foreach ($users as $ind => $row){
            if (!isset($votes[$row->id])) $votes[$row->id] = ['avg' => 0, 'cnt' => 0];
            $row->rate = $votes[$row->id];
            $users[$ind] = $row;
        }
        return $users;
    }
    public static function addRow($data){
        if (is_object($data)) $data = (array)$data;
        if (isset($data['id'])){
            $row = Users::find($data['id']);
            unset($data['id']);
        }else{
            $row = new Users();
        }
        foreach ($data as $ind => $val){
            $row[$ind] = $val;
        }
        $row->save();
    }
}

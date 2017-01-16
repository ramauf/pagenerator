<?php

namespace App\Http\Models;

//use App\Http\Models\Accepts;
use DB;
//use App\Http\Models\Points;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class Posts extends Model
{
    protected $table = 'posts';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'points_idFrom',
        'points_idTo',
        'users_id',
        'totalPlace',
        'freePlace',
        'status',
        'cost',
        'distance',
        'time',
        'createdTime',
        'startTime',
        'endTime',
        'comment'
    ];
    public static $luggage = [
        'none' => 'Отсутствует',
        'small' => 'Маленький',
        'medium' => 'Средний',
        'large' => 'Большой'
    ];

    public static function takePlace(){
        $res = DB::select('SELECT * FROM `posts` WHERE `freePlace`*1 < `totalPlace` * 1 ORDER BY `startTime` ASC LIMIT 3');
        foreach ($res as $row){
            //
        }
    }
    
    public static function acceptPost($data, $posts_id){
        $post = [
            'response' => $data['g-recaptcha-response'],
            'secret' => '6LfrYAgUAAAAAKczJcgrKoCAVyp9zKjfITmxfcFj',
            'remoteip' => $_SERVER['REMOTE_ADDR']
        ];
        $res = json_decode(Functions::sendPost('https://www.google.com/recaptcha/api/siteverify', ['postdata' => $post]));
        if ($res->success) {
            Accepts::add([
                'users_id' => Session::get('users')->id,
                'posts_id' => $posts_id
            ]);
            return ['status' => true];
        }else{
            return ['status' => false, 'errorsList' => ['captcha' => 'Капча введена неверно']];
        }
    }

    public static function getUnacceptedPosts($limit = 2){//Получить посты, у которых есть пассажирские места
        $posts = DB::select('SELECT * FROM `posts` WHERE `status` = "wait" AND `startTime`*1 > '.time().' ORDER BY `startTime`*1 ASC');
        $accepts = [0];
        foreach ($posts as $post){
            $accepts[$post->id] = 0;
        }
        $res = DB::select('SELECT `posts_id`, SUM(1) AS `cnt` FROM `accepts` WHERE `posts_id` IN('.implode(',', array_keys($accepts)).') AND `status` = "accepted" GROUP BY `posts_id`');
        foreach ($res as $row){
            $accepts[$row->posts_id] = $row->cnt;
        }
        foreach ($posts as $ind => $row){
            //$row->freePlace = $row->freePlace - $accepts[$row->id];
            if ($row->freePlace - $accepts[$row->id] <= 0)unset($posts[$ind]);
        }
        unset($accepts);
        return array_slice($posts, 0, $limit);
    }
    public static function getSitemap(){
        $posts = DB::select('SELECT `id`, `points_idFrom`, `points_idTo` FROM `posts`');


        $points = $cities = [0];
        foreach ($posts as $post){
            $points[$post->points_idFrom] = 0;
            $points[$post->points_idTo] = 0;
        }

        $res = DB::select('SELECT `id`, `cities_id` FROM `points` WHERE `id` IN('.implode(',', array_keys($points)).')');
        foreach ($res as $row){
            $points[$row->id] = $row->cities_id;
        }
        //var_dump($points);exit;
        $res = DB::select('SELECT `id`, `transname` FROM `cities`');
        foreach ($res as $row){
            $cities[$row->id] = $row->transname;
        }
        $sitemap = [];
        foreach ($posts as $ind => $row){
            /*$row->pointFrom = $cities[$points[$row->points_idFrom]];
            $row->pointTo = $cities[$points[$row->points_idTo]];
            $posts[$ind] = $row;*/
            $from = $cities[$points[$row->points_idFrom]];
            $to = $cities[$points[$row->points_idTo]];
            if (!isset($sitemap[$from][$to])) $sitemap[$from][$to] = [];
            $sitemap[$from][$to][] = $row->id;
        }
        unset($points, $cities, $posts);
        return $sitemap;
        
    }

    public static function getPosts($condy = []){
        $limit = $addon = '';
        $orderType = $groupBy = '`startTime`*1';
        $orderDirect = 'ASC';
        if (isset($condy['limit'])) $limit = 'LIMIT '.$condy['limit'];
        if (isset($condy['ids'])) $addon .= ' AND `id` IN('.implode(',', $condy['ids']).')';
        if (isset($condy['future'])) $addon .= ' AND `startTime`*1 > '.time();
        if (isset($condy['date'])){//Смотрим по дате (архив)
            if (preg_match('|^(\d{1,2})\.(\d{4})$|', $condy['date'], $m)){
                $addon .= ' AND `startTime`*1 > '.mktime(0, 0, 0, $m[1], 1, $m[2]).' AND `startTime`*1 < '.mktime(0, 0, 0, $m[1]+1, 1, $m[2]);
            }
        }
        if (isset($condy['orderType'])) $orderType = $condy['orderType'];
        if (isset($condy['orderDirect'])) $orderDirect = $condy['orderDirect'];
        if (isset($condy['groupBy'])){
            $groupBy = $condy['groupBy'];
            if ($condy['groupBy'] == 'direction') $groupBy = 'CONCAT (`points_idFrom`, "_", `points_idTo`)';
        }
        if (isset($condy['isRand'])){
            $orderType = 'RAND()';
            $orderDirect = '';
        }
        if (isset($condy['posts_id'])){
            $addon = ' AND `id` = "'.$condy['posts_id'].'"';
        }
        if (isset($condy['cities_transname1'])){
            $cities_id = Cities::where('transname',$condy['cities_transname1'])->first()->id;
            $res = Points::where('cities_id', $cities_id)->get();
            $pointsIds = [0];
            foreach ($res as $row) $pointsIds[] = $row->id;
            $addon .= ' AND (`points_idFrom` IN('.implode(',', $pointsIds).'))';
        }
        if (isset($condy['cities_transname2'])){
            $cities_id = Cities::where('transname',$condy['cities_transname2'])->first()->id;
            $res = Points::where('cities_id', $cities_id)->get();
            $pointsIds = [0];
            foreach ($res as $row) $pointsIds[] = $row->id;
            $addon .= ' AND (`points_idTo` IN('.implode(',', $pointsIds).'))';
        }

        $posts = DB::select('SELECT SQL_CALC_FOUND_ROWS * FROM `posts` WHERE 1 '.$addon.' GROUP BY '.$groupBy.' ORDER BY '.$orderType.' '.$orderDirect.' '.$limit);
        $postPages = DB::select('SELECT FOUND_ROWS() AS `cnt`')[0]->cnt;
        $postPages = ceil($postPages/50);


        $points = $users = $cities = $accepts = [0];
        foreach ($posts as $post){
            $points[$post->points_idFrom] = [];
            $points[$post->points_idTo] = [];
            $users[$post->users_id] = [];
            $accepts[$post->id] = 0;
        }
        $selfAccepts = [];
        if (Session::has('users')){
            $res = DB::select('SELECT * FROM `accepts` WHERE `posts_id` IN('.implode(',', array_keys($accepts)).') AND `users_id` = ? GROUP BY `posts_id`', [Session::get('users')->id]);
            foreach ($res as $row){
                $selfAccepts[$row->posts_id] = $row->status;
            }
        }
        $res = DB::select('SELECT `posts_id`, SUM(1) AS `cnt` FROM `accepts` WHERE `posts_id` IN('.implode(',', array_keys($accepts)).') AND `status` = "accepted" GROUP BY `posts_id`');
        foreach ($res as $row){
            $accepts[$row->posts_id] = $row->cnt;
        }
        $res = DB::select('SELECT * FROM `points` WHERE `id` IN('.implode(',', array_keys($points)).')');
        foreach ($res as $row){
            $coord = explode(' ', $row->coord);
            $row->coord = $coord[1].', '.$coord[0];
            $points[$row->id] = (array)$row;
            $cities[$row->cities_id] = [];
        }
        //$res = DB::select('SELECT * FROM `users` WHERE `id` IN('.implode(',', array_keys($users)).')');
        $res = Users::getUsers(['ids' => array_keys($users)]);
        foreach ($res as $row){
            $users[$row->id] = (array)$row;
        }
        $res = DB::select('SELECT * FROM `cities` WHERE `id` IN('.implode(',', array_keys($cities)).')');
        foreach ($res as $row){
            $cities[$row->id] = (array)$row;
        }
        unset($users[0], $points[0], $cities[0]);
        foreach ($posts as $ind => $row){
            $row->freePlace = $row->freePlace - $accepts[$row->id];
            $row->luggageName = self::$luggage[$row->luggage];
            $row->pointFrom = $points[$row->points_idFrom];
            $row->pointFrom['name'] = $cities[$row->pointFrom['cities_id']]['name'];
            $row->pointFrom['transname'] = $cities[$row->pointFrom['cities_id']]['transname'];
            $row->pointFrom['address'] = str_replace('Россия, ', '', $row->pointFrom['address']);
            $row->pointTo = $points[$row->points_idTo];
            $row->pointTo['name'] = $cities[$row->pointTo['cities_id']]['name'];
            $row->pointTo['transname'] = $cities[$row->pointTo['cities_id']]['transname'];
            $row->pointTo['address'] = str_replace('Россия, ', '', $row->pointTo['address']);
            $row->user = $users[$row->users_id];
            $posts[$ind] = $row;
        }
        return ['posts' => $posts, 'postPages' => $postPages, 'selfAccepts' => $selfAccepts];
    }

    public static function generateRow(){
        //Сгенерировать запись
        $post = [];
        $post['totalPlace'] = 5;
        if (rand(1, 10) == 2) $post['totalPlace'] = 7;
        $post['freePlace'] = $post['totalPlace'] - rand(1, $post['totalPlace'] - 1);
        $post['status'] = 'wait';
        $post['createdTime'] = time();
        //$user = Users::getRandomUsers();
        $user = Users::getUsers(['isRand' => ''])[0];//Выберем рандомного юзверя
        $distances = Cities::getDistances($user->cities_id);//Выберем городаа вокруг города данного юзверя
        $cities_id = key($distances);//Выберем из верхней позиции
        $tmp = Points::getInfo($user->points_id);
        $user->startPoint = $tmp->address;
        $point = Points::getRandomPoint($cities_id)[0];//Выберем рандомную улицу из данного города
        $post['points_idFrom'] = $user->points_id;
        $post['points_idTo'] = $point->id;
        $post['users_id'] = $user->id;
        $post['luggage'] = array_rand(self::$luggage);

        $googleapi = config('googleapi');
        $data = file_get_contents('https://maps.googleapis.com/maps/api/distancematrix/json?origins='.urlencode($user->startPoint).'&destinations='.urlencode($point->address).'&key='.$googleapi['key']);
        $data = json_decode($data);


        if ($data->rows[0]->elements[0]->status == 'OK'){//Успешно просчитано
            $post['distance'] = $data->rows[0]->elements[0]->distance->value;
            $post['duration'] = $data->rows[0]->elements[0]->duration->value;
            $post['cost'] = $post['distance'] / 1000 * round(12, 18) / 10;
            $post['cost'] = round($post['cost'] / 100) * 100;
            $post['startTime'] = time() + rand(1, 4) * 60 * 60 * 24;
            $post['startTime'] = round($post['startTime'] / 1800) * 1800;
            $post['endTime'] = $post['startTime'] + round(($post['duration'] * 1.2) / 3600) * 3600;
            if ($post['cost'] > 0 && $post['distance'] > 0) {
                Posts::addRow($post);
                return true;
            }
        }
        return false;
    }
    public static function addRow($data){
        //Добавить запись в бд
        if (isset($data['id'])){
            $row = Posts::find($data['id']);
            unset($data['id']);
        }else{
            $row = new Posts();
        }
        foreach ($data as $ind => $val){
            $row[$ind] = $val;
        }
        $row->save();

    }
}

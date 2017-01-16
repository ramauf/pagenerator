<?php

namespace App\Http\Models;

use DB;
use Illuminate\Database\Eloquent\Model;

class Cities extends Model
{
    protected $table = 'cities';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'regions_id',
        'name',
        'population',
        'area',
        'chance'
    ];
    public static function getWords(){
        return DB::select('SELECT SUBSTRING(`name`, 1, 1) AS `word`, SUBSTRING(`transname`, 1, 1) AS `transword` FROM `cities` GROUP BY `transword`');
    }
    public static function getCities($word = ''){
        if (empty($word)){
            return Cities::all();
        }else{
            return Cities::whereRaw('`transname` LIKE("'.$word.'%")')->get();
        }
    }
    

    public static function getRandomCity($type = 'exp'){
        //Выбрать рандомный город в зависимости от численности населения
        //$type = 'exp' - чем больше населения - тем больше вероятность выбора города
        //$type = 'dir' - вероятность не зависит от населения города
        if ($type == 'exp') return DB::select('SELECT *, RAND()*`chance` AS `rnd` FROM `cities` WHERE 1 ORDER BY `rnd` DESC LIMIT 1');
        if ($type == 'dir') return DB::select('SELECT * FROM `cities` ORDER BY RAND() LIMIT 1');
    }

    public static function getDistances($cities_id){
        //Вычислить матрицу относительных растояний от текущего города до всех остальных
        $target = DB::select('SELECT * FROM `cities` WHERE `id` = ?', [$cities_id]);
        $target = $target[0];
        $coords = preg_split('|[ ;]|', $target->area);
        $target->center = [($coords[2]+$coords[0])/2, ($coords[3]-$coords[1])/2];

        $cities = DB::select('SELECT * FROM `cities` WHERE `id` != ?', [$cities_id]);
        $distances = [];
        //$tmp = [];
        foreach ($cities as $ind => $city){
            $coords = preg_split('|[ ;]|', $city->area);
            $center = [($coords[2]+$coords[0])/2, ($coords[3]-$coords[1])/2];
            $interval = sqrt(pow($target->center[0] - $center[0], 2)+pow($target->center[1] - $center[1], 2));
            $rand = mt_rand()/mt_getrandmax();
            $distances[$city->id] = $interval==0?0:$rand*$city->population/$interval;
            //$tmp[$city->id] = $city->name;
        }
        arsort($distances);
        return $distances;
    }
}

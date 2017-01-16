<?php

namespace App\Http\Controllers;

use App\Http\Models\Accepts;
use App\Http\Models\Users;
use App\Http\Models\Posts;
use App\Http\Models\Cities;
use App\Http\Models\Functions;
use App\Http\Models\Points;
use App\Http\Models\Votes;
use Illuminate\Http\Request;

use App\Http\Requests;
//use App\Http\Models;
use DB;
class CronController extends Controller
{
    public function getIndex(){
        //
    }
    public function addaccepts(){//Добавляем пассажира на машинку
        /*
         * Вызывать каждые 10 минут по 1000 постов с вероятностью 0,5% занимать место в машинке
         * количество занятых мест в сутки = 6*24*1000*0,5/100=720 на 1000 постов
         * количество занятых мест в сутки = 6*24*100*0.5/100=72 на 100 постов
         * количество занятых мест в сутки = 6*24*10*0.5/100=7 на 10 постов
         * количество занятых мест в сутки = 6*24*1000*1/100=1440 на 1000 постов
         * 6*24*200*0.15=4320 (если добавлть по 1440 постов в день, то получится 4320/1440=3 занятых места на пост в день
         * */
        Accepts::accept(200, 15);
    }
    public function addvote(){
        Votes::setVote(0, -1, 40);
    }
    public function addpost($count = 100){
        Users::setStartPoints();
        for ($i = 0; $i < $count; $i++){
            Posts::generateRow();
        }
    }
    public function parseaddress(){

        //$url = Laracurl::buildUrl('http://poputchik.ru/log.php', ['token' => 'token_val']);
        $post = ['qwe' => 'asd'];
        $res = Functions::sendPost('http://poputchik.ru/log.php', $post);
        $randomCity = Cities::getRandomCity('exp');
        $randomCity = $randomCity[0];
        $area = preg_split('|[ ;]|', $randomCity->area);
        for ($i = 1; $i <= 10; $i++){
            $delta = ['x' => $area[2] - $area[0], 'y' => $area[3] - $area[1]];
            $area[0] += $delta['x']*0.2;
            $area[1] += $delta['y']*0.2;
            $area[2] -= $delta['x']*0.2;
            $area[3] -= $delta['y']*0.2;
            $point = (mt_rand($area[0]*1000000, $area[2]*1000000)/1000000).' '.(mt_rand($area[1]*1000000, $area[3]*1000000)/1000000);
            $data = simplexml_load_string(file_get_contents('https://geocode-maps.yandex.ru/1.x/?geocode='.$point));
            if (isset($data->GeoObjectCollection->featureMember)) foreach ($data->GeoObjectCollection->featureMember as $row){
                if ($row->GeoObject->metaDataProperty->GeocoderMetaData->kind == 'street'){
                    //var_dump($row);
                    Points::addRow([
                        'cities_id' => $randomCity->id,
                        'coord' => $row->GeoObject->Point->pos,
                        'address' => $row->GeoObject->metaDataProperty->GeocoderMetaData->text
                    ]);
                    echo 'OK<br />'.PHP_EOL;
                    break(2);
                }
            }
        }

        echo $randomCity->name.': '.$i;
        exit('<script type = "text/javascript">window.location.reload();</script>');
    }
}

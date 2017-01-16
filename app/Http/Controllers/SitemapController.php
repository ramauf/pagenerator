<?php

namespace App\Http\Controllers;

use App\Http\Models\Cities;
//use Illuminate\Http\Request;

use App\Http\Models\Posts;
use App\Http\Requests;
//use Illuminate\Support\Facades\View;


class SitemapController extends IndexController
{

    public function index(){
        $xml = '<'.'?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'.PHP_EOL;
        $cities = Cities::getCities();
        foreach ($cities as $city){
            $xml .= '<url><loc>http://'.$_SERVER['HTTP_HOST'].'/poputchik/'.$city->transname.'</loc></url>'.PHP_EOL;
        }
        unset($cities);
        $posts = Posts::getSitemap();
        foreach ($posts as $ind => $val){
            foreach ($val as $ind2 => $val2){
                $xml .= '<url><loc>http://'.$_SERVER['HTTP_HOST'].'/poputchik/'.strtolower($ind.'/'.$ind2).'</loc></url>'.PHP_EOL;
                foreach ($val2 as $ind3 => $val3){
                    //var_dump($ind, $ind2, $val3);
                    $xml .= '<url><loc>http://'.$_SERVER['HTTP_HOST'].'/poputchik/'.strtolower($ind.'/'.$ind2).'/'.$val3.'</loc></url>'.PHP_EOL;
                }
            }
        }

        $xml .= '</urlset>';
        return $xml;
    }
}

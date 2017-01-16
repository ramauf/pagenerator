<?php

namespace App\Http\Controllers;

use App\Http\Models\Cities;
use Illuminate\Http\Request;

use App\Http\Requests;
//use Illuminate\Support\Facades\View;


class CitiesController extends IndexController
{
    
    public function index($word = '', $city = ''){
        //$t = Cities::getWords();
        //foreach ($t as $w) var_dump($w->word);exit;
        //var_dump(Cities::getWords());exit;
        if (empty($word)) return redirect('/cities/a');
        $this->templateData['menuName'] = 'Попутчики из города';
        $this->templateData['words'] = Cities::getWords();
        $this->templateData['cities'] = Cities::getCities($word);
        $this->templateData['subTemplate'] = 'cities.list';
        return view($this->mainTemplate, $this->templateData);
        
        /*if (empty($cities_transname1)) {
            $posts = Posts::getPosts();
            $this->templateData['menuName'] = 'Поиск попутчика';
        }elseif(empty($cities_transname2)){
            $posts = Posts::getPosts(['cities_transname1' => $cities_transname1]);
            $name = '';
            $this->templateData['menuName'] = 'Попутчики из города "'.$posts[0]->pointFrom['name'].'"';
        }else{
            $posts = Posts::getPosts(['cities_transname1' => $cities_transname1, 'cities_transname2' => $cities_transname2]);
            //var_dump($cities_transname1, $cities_transname2);exit;
            $this->templateData['menuName'] = 'Попутчики из "'.$posts[0]->pointFrom['name'].'" в "'.$posts[0]->pointTo['name'].'"';
        }

        $this->templateData['posts'] = $posts;
        $this->templateData['subTemplate'] = 'posts.list';
        return view($this->mainTemplate, $this->templateData);*/
    }
}

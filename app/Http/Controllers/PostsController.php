<?php

namespace App\Http\Controllers;

//use App\Http\Models\Cities;
use App\Http\Models\Functions;
use App\Http\Models\Posts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Http\Requests;
//use Illuminate\Support\Facades\View;


class PostsController extends IndexController
{
    public function archive(){
        //
    }
    public function details(Request $request, $cities_transname1, $cities_transname2, $posts_id){
        if ($request->isMethod('post')) {
            $res = Posts::acceptPost($request->all(), $posts_id);
            if ($res['status']) {
                $this->templateData['menuName'] = 'Заявка принята';
                $this->templateData['subTemplate'] = 'posts.accepted';
                return view($this->mainTemplate, $this->templateData);
            } else {
                $this->templateData['errorsList'] = $res['errorsList'];
            }
        }
        $this->templateData['menuName'] = 'Описание маршрута';
        //var_dump($city_transnameFrom, $city_transnameTo, $posts_id);
        $tmp = Posts::getPosts(['posts_id' => $posts_id]);
        $post = $tmp['posts'][0];
        $this->templateData['selfAccepts'] = $tmp['selfAccepts'];
        $this->templateData['post'] = $post;
        $this->templateData['subTemplate'] = 'posts.single';
        //var_dump($this->templateData['post']);
        $this->templateData['menuName'] = 'Попутчики из "' . $post->pointFrom['name'] . '" в "' . $post->pointTo['name'] . '" на '.date('j', $post->startTime).' '.Functions::getMonths(2)[date('m', $post->startTime)].' '.date('Y', $post->startTime).' г.';
        $this->templateData['meta']['title'] = 'Попутчики из "' . $post->pointFrom['name'] . '" в "' . $post->pointTo['name'] . '" на '.date('j', $post->startTime).' '.Functions::getMonths(2)[date('m', $post->startTime)].' '.date('Y', $post->startTime).' г.';
        $this->templateData['meta']['keywords'] = 'попутчики из ' . $post->pointFrom['name'] . ' в ' . $post->pointTo['name'] . ' на '.date('j', $post->startTime).' '.Functions::getMonths(2)[date('m', $post->startTime)].' '.date('Y', $post->startTime).' г.';
        $this->templateData['meta']['description'] = 'Попутчики из "' . $post->pointFrom['name'] . '" в "' . $post->pointTo['name'] . '" на '.date('j', $post->startTime).' '.Functions::getMonths(2)[date('m', $post->startTime)].' '.date('Y', $post->startTime).' г.';

        return view($this->mainTemplate, $this->templateData);
    }
    public function index(Request $request, $cities_transname1 = '', $cities_transname2 = ''){
        $this->templateData['subTemplate'] = 'posts.list';
        if (!isset($_GET['page'])) $_GET['page'] = 1;
        $limit = '';
        $validator = Validator::make(['page' => $_GET['page']],['page' => 'required|integer']);
        if ($validator->passes()){
            $limit = (50*($_GET['page']-1)).', 50';
        }
        if (empty($cities_transname1)) {
            $tmp = Posts::getPosts(['groupBy' => 'direction', 'future' => 1, 'limit' => $limit]);
            $posts = $tmp['posts'];
            $postPages = $tmp['postPages'];
            $this->templateData['menuName'] = 'Поиск попутчика';
        }elseif(empty($cities_transname2)){
            $tmp = Posts::getPosts(['cities_transname1' => $cities_transname1, 'future' => 1, 'limit' => $limit]);
            $posts = $tmp['posts'];
            $postPages = $tmp['postPages'];
            if (!isset($posts[0])){
                $this->templateData['menuName'] = 'Попутчики отсутствуют';
            }else{
                $this->templateData['menuName'] = 'Попутчики из города "'.$posts[0]->pointFrom['name'].'"';
                $this->templateData['meta']['title'] = 'Попутчики из города "'.$posts[0]->pointFrom['name'].'"';
                $this->templateData['meta']['keywords'] = 'попутчики из города '.$posts[0]->pointFrom['name'];
                $this->templateData['meta']['description'] = 'Найти всех попутчиков из города "'.$posts[0]->pointFrom['name'].'"';
            }
        }else{
            $this->templateData['subTemplate'] = 'posts.list2';
            $data = [
                'cities_transname1' => $cities_transname1, 
                'cities_transname2' => $cities_transname2, 
                'future' => 1,
                'limit' => $limit
            ];
            if ($request->get('date') !== null){
                $data['date'] = $request->get('date');
                unset($data['future']);
            }
            $tmp = Posts::getPosts($data);
            $posts = $tmp['posts'];
            $postPages = $tmp['postPages'];
            if (!isset($posts[0])){
                $this->templateData['menuName'] = 'Попутчики отсутствуют';
            }else{
                $this->templateData['menuName'] = 'Попутчики из "'.$posts[0]->pointFrom['name'].'" в "'.$posts[0]->pointTo['name'].'"';
                $this->templateData['meta']['title'] = 'Попутчики между городами "'.$posts[0]->pointFrom['name'].'" и "'.$posts[0]->pointTo['name'].'"';
                $this->templateData['meta']['keywords'] = 'попутчики между городами '.$posts[0]->pointFrom['name'].' и '.$posts[0]->pointTo['name'];
                $this->templateData['meta']['description'] = 'Найти всех попутчиков между городами "'.$posts[0]->pointFrom['name'].'" и "'.$posts[0]->pointTo['name'].'"';
                if ($request->get('date') !== null){
                    if (preg_match('|^(\d{1,2})\.(\d{4})$|', $request->get('date'), $m)) {
                        $this->templateData['menuName'] = 'Попутчики из "' . $posts[0]->pointFrom['name'] . '" в "' . $posts[0]->pointTo['name'] . '" на '.Functions::getMonths()[$m[1]].' '.$m[2].' г.';
                        $this->templateData['meta']['title'] = 'Попутчики из "'.$posts[0]->pointFrom['name'].'" в "' . $posts[0]->pointTo['name'] . '" на '.Functions::getMonths()[$m[1]].' '.$m[2].' г.';
                        $this->templateData['meta']['keywords'] = 'попутчики из '.$posts[0]->pointFrom['name'].' в ' . $posts[0]->pointTo['name'] . ' на '.Functions::getMonths()[$m[1]].' '.$m[2].' г.';
                        $this->templateData['meta']['description'] = 'Найти всех попутчиков из города "'.$posts[0]->pointFrom['name'].'" в "' . $posts[0]->pointTo['name'] . '" на '.Functions::getMonths()[$m[1]].' '.$m[2].' г.';
                    }
                }
            }
        }

        $this->templateData['months'] = Functions::getMonths();
        $this->templateData['posts'] = $posts;
        $this->templateData['postPages'] = $postPages;
        return view($this->mainTemplate, $this->templateData);
    }
}

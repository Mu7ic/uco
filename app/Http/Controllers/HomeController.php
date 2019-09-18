<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        return view('welcome');
    }

    public function ajaxRequestPost(Request $request)

    {

        $json='[
  {
    "item": [
      {
        "id": 0,
        "isActive": true,
        "age": 35,
        "eyeColor": "brown",
        "name": "Isabel Noel",
        "gender": "female",
        "company": "RUBADUB",
        "email": "isabelnoel@rubadub.com",
        "phone": "+1 (905) 515-2287",
        "address": "353 Vanderveer Place, Welda, Texas, 3873"
      }
    ]
  },
  {
    "item": [
      {
        "id": 1,
        "isActive": true,
        "age": 28,
        "eyeColor": "green",
        "name": "Campos Pittman",
        "gender": "male",
        "company": "EVENTIX",
        "email": "campospittman@eventix.com",
        "phone": "+1 (847) 543-3337",
        "address": "860 Ralph Avenue, Yettem, Louisiana, 726"
      }
    ]
  },
  {
    "item": [
      {
        "id": 2,
        "isActive": true,
        "age": 28,
        "eyeColor": "brown",
        "name": "Sharpe French",
        "gender": "male",
        "company": "QUAREX",
        "email": "sharpefrench@quarex.com",
        "phone": "+1 (869) 472-3624",
        "address": "131 Hinsdale Street, Gasquet, Federated States Of Micronesia, 5052"
      }
    ]
  },
  {
    "item": [
      {
        "id": 3,
        "isActive": false,
        "age": 31,
        "eyeColor": "brown",
        "name": "Teresa Bush",
        "gender": "female",
        "company": "OVIUM",
        "email": "teresabush@ovium.com",
        "phone": "+1 (957) 433-3564",
        "address": "257 Williams Place, Elizaville, North Carolina, 2007"
      }
    ]
  },
  {
    "item": [
      {
        "id": 4,
        "isActive": true,
        "age": 33,
        "eyeColor": "green",
        "name": "Lowe Horne",
        "gender": "male",
        "company": "BARKARAMA",
        "email": "lowehorne@barkarama.com",
        "phone": "+1 (967) 560-3576",
        "address": "894 Amboy Street, Skyland, Connecticut, 156"
      }
    ]
  },
  {
    "item": [
      {
        "id": 5,
        "isActive": true,
        "age": 21,
        "eyeColor": "blue",
        "name": "Minnie Reese",
        "gender": "female",
        "company": "EPLODE",
        "email": "minniereese@eplode.com",
        "phone": "+1 (855) 481-3494",
        "address": "703 Prospect Place, Wilmington, Indiana, 1827"
      }
    ]
  }
]';

        $array = json_decode($json, true);

        foreach ($array as $arr) {
            if($arr['item'][0]['isActive']==true) {
                $list[] = [
                    'age' => $arr['item'][0]['age'],
                    'eyeColor' => $arr['item'][0]['eyeColor'],
                    'name' => $arr['item'][0]['name'],
                    'gender' => $arr['item'][0]['gender'],
                    'company' => $arr['item'][0]['company'],
                    'email' => $arr['item'][0]['email'],
                    'phone' => $arr['item'][0]['phone'],
                    'address' => $arr['item'][0]['address'],
                    'isActive' => $arr['item'][0]['isActive'],
                ];
            }
        }

        $page = !isset($_GET['page']) ? 1 : $_GET['page'];
        Session::put('page',$page);
        $limit = 2*Session::get('page');
        $offset = 0;
        $total_items = count($list);
        $total_pages = ceil($total_items / $limit);
        Session::put('total',$total_pages);

        if(Session::get('page')>Session::get('total_pages'))
            Session::put('page',$total_pages);

        $array = array_splice($list, $offset, $limit);
        echo $offset;
        echo '<br>';
        echo $limit;
        echo '<br>';
        echo $total_items;
//        echo '<pre>';
//        var_dump($list);
//        echo '</pre>';

        if (isset($_GET['sort'])) {
            if (Session::get('key') != $_GET['sort']) {
                Session::put('key', $_GET['sort']);

                usort($array, function ($item1, $item2) {
                    return $item1[$_GET['sort']] <=> $item2[$_GET['sort']];
                });
            } else {
                usort($array, function ($item1, $item2) {
                    return $item2[$_GET['sort']] <=> $item1[$_GET['sort']];
                });
            }
        }

        $this->getTable($array);
    }

    private function getTable($list){
        echo '<table id="customers">';
        echo '<tr>';
        echo '<th><a class="ajax-class" onclick="sorting(\'age\')" href="javascript:void(0)">Возраст</a></th>';
        echo '<th><a class="ajax-class" onclick="sorting(\'eyeColor\')" data-content="eyeColor" href="javascript:void(0)">Цвет глаз</a></th>';
        echo '<th><a class="ajax-class" onclick="sorting(\'name\')" data-content="name" href="javascript:void(0)">Имя</a></th>';
        echo '<th><a class="ajax-class" onclick="sorting(\'gender\')" data-content="gender" href="javascript:void(0)">Пол</a></th>';
        echo '<th><a class="ajax-class" onclick="sorting(\'company\')" data-content="company" href="javascript:void(0)">Компания</a></th>';
        echo '<th><a class="ajax-class" onclick="sorting(\'email\')" data-content="email" href="javascript:void(0)">Email</a></th>';
        echo '<th><a class="ajax-class" onclick="sorting(\'phone\')" data-content="phone" href="javascript:void(0)">Телефон</a></th>';
        echo '<th><a class="ajax-class" onclick="sorting(\'address\')" data-content="address" href="javascript:void(0)">Адрес</a></th>';
        echo '</tr>';

        foreach ($list as $l){
            echo '<tr>';
            echo '<td>'.$l['age'].'</td>';
            echo '<td>'.$l['eyeColor'].'</td>';
            echo '<td>'.$l['name'].'</td>';
            echo '<td>'.$l['gender'].'</td>';
            echo '<td>'.$l['company'].'</td>';
            echo '<td>'.$l['email'].'</td>';
            echo '<td>'.$l['phone'].'</td>';
            echo '<td>'.$l['address'].'</td>';
            echo '</tr>';
            }

        echo '</table>';
    }
}

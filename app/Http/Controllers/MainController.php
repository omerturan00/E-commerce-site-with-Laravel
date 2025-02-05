<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MainController extends Controller
{

    public function __construct()
    {
        $this->data = [];
        $this->data['pageTitle'] = "Dedeoğlu Giyim";
        $this->url = "http://dedeoglu.dehapi.com/";
    }

    public function index()
    {
        $url = $this->url."api/products";
        if (session('login') == true){
            $response = Http::withHeaders(
                ['Authorization' => session('tokenType').' '.session('token'),
            ])->get($url);
        }else{
            $response = Http::get($url);
        }
        $products = $response->json();
        $this->data['products'] = $products['products'];
         return view('index', $this->data);
    }





    public function shoppingBag()
    {
        $url = $this->url."api/user/cart/get";
        $response = Http::withHeaders(
            ['Authorization' => session('tokenType').' '.session('token'),
            ])->get($url);
        if ($response->successful()){

        }else{
            echo "b";
        }
    }
    public function addToCart(Request $request)
    {
       $url = $this->url."api/user/cart/add";
       $response = Http::post($url, [
           'products' => [
               'product_id' => $request['product_id'],
               'quantity' => 1
           ]
       ]);
       if ($response->successful()){
            echo "okey";
       }else{
            echo "no";
       }
    }
}

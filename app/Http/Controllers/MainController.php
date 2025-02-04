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





    public function addToCart(Request $request)
    {
       $url = $this->url."api/user/cart/add";
       $data = [
           'products' => [
                'product_id' => $request['product_id'],
                'quantity' => 1
           ]
       ];
       $response = Http::post($url, $data);
       if ($response->successful()){
            echo "okey";
       }else{
           echo "olmadı yar";
       }
    }
}

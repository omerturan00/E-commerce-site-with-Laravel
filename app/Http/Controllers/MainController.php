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
        $response = Http::get($url);
        $products = $response->json();
        $this->data['products'] = $products['products'];

        dd($this->data['products']);
       // return view('index', $this->data);


    }
}

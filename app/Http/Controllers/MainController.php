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
        $categoriurl = $this->url."api/categories";
        $response = Http::get($categoriurl);
        if ($response->successful()){
            $this->data['categories'] = $response['categories'];
        }
        $url = $this->url."api/products";
        if (session('login') == true){
            $response = Http::withHeaders(['Authorization' => session('tokenType').' '.session('token'),
            ])->get($url);
        }else{
            $response = Http::get($url);
        }
        $products = $response->json();
        $this->data['products'] = $products['products'];



        $this->data['brands'] = [];
        $this->data['brandsslugs'] = [];
        foreach ($this->data['products'] as $product) {
            if (!in_array($product['brand'], $this->data['brands'])){
                array_push($this->data['brands'], $product['brand']);
                array_push($this->data['brandsslugs'], $product['brand_slug']);
            }
        }

    }

    public function index()
    {

        return view('index', $this->data);
    }





    public function shoppingBag()
    {
        $this->data['pageTitle'] = "Sepetim";
        $url = $this->url."api/user/cart/get";
        $response = Http::withHeaders([
            'Authorization' => session('tokenType') . ' ' . session('token'),
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
            ])->get($url);
        if ($response->successful()){

            $this->data['carts'] = $response['cart'];
            if (!empty($this->data['carts'])){
            $this->data['emptyShoppingBagMessage'] = "";
            }else{
                $this->data['emptyShoppingBagMessage'] = "Sepetinizde gösterilecek ürün bulunmamaktadır.";
            }
        }else{
            $this->data['carts'] = "";
            $this->data['emptyShoppingBagMessage'] = "Sepetinizde gösterilecek ürün bulunmamaktadır.";
        }

        return view('cart', $this->data);
    }
    public function addToCart(Request $request)
    {
       $url = $this->url."api/user/cart/add";
        $response = Http::withHeaders([
            'Authorization' => session('tokenType') . ' ' . session('token'),
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ])->post($url, [
            'products' => [
                [
                    'product_id' => $request->input('product_id'),
                    'quantity' => 1
                ]
            ]
        ]);
       if ($response->successful()){
           echo "a";
       }
    }
    public function deleteToCart(Request $request)
    {
        $url = $this->url."api/user/cart/extraction";
        $response = Http::withHeaders([
            'Authorization' => session('tokenType') . ' ' . session('token'),
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ])->post($url, [
            "product_id" => $request->id
        ]);
        if ($response->successful()){
            return redirect()->to(route('shoppingBag'));
        }
    }
    public function shoppingBagInc(Request $request)
    {
        $url = $this->url."api/user/cart/increment";
        $response = Http::withHeaders([
            'Authorization' => session('tokenType') . ' ' . session('token'),
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ])->post($url, [
            "product_id" => $request->id,
            "quantity" => 1
        ]);
        if ($response->successful()){
            return redirect()->to(route('shoppingBag'));
        }
    }
    public function shoppingBagDec(Request $request)
    {
        $url = $this->url."api/user/cart/decrement";
        $response = Http::withHeaders([
            'Authorization' => session('tokenType') . ' ' . session('token'),
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ])->post($url, [
            "product_id" => $request->id,
            "quantity" => 1
        ]);
        if ($response->successful()){
            return redirect()->to(route('shoppingBag'));
        }
    }
    public function shoppingBagReset()
    {
        $url = $this->url."api/user/cart/delete";
        $response = Http::withHeaders([
            'Authorization' => session('tokenType') . ' ' . session('token'),
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ])->post($url);
        if ($response->successful()){
            return redirect()->to(route('shoppingBag'));
        }
    }

    public function categoryDetail(Request $request)
    {
        $this->data['pageUrl'] = request()->fullUrl();
        $this->data['slug'] = $request->slug;
        $this->data['sub_cats'] = [];
        $this->data['urunler'] = [];

         




         foreach ($this->data['categories'] as $category) {
            if ($category['slug'] == $this->data['slug']){
                $sub_cats = $category;
            }
        }
       $this->data['sub_cats'] = $sub_cats['sub_categories'];
       // return view('shop', $this->data);
    }
    public function subCategoryDetail(Request $request)
    {
        if (isset($request->brand)){$this->data['brand'] = $request->brand;}
        if (isset($request->min)){$this->data['min'] = $request->min;}
        if (isset($request->max)){$this->data['max'] = $request->max;}
        $currentUrl = request()->url();
        dd($currentUrl);
        $this->data['slug'] = $request['slug'];
        $this->data['sub_cats'] = [];

        $parrent = [];
        foreach ($this->data['categories'] as $category) {
            foreach ($category['sub_categories'] as $sub_category) {
                if ($sub_category['slug'] == $this->data['slug']){
                    $parrent = $category;
                }
           }
        }

        $this->data['sub_cats'] = $parrent['sub_categories'];

         return view('categorydetail', $this->data);
    }
}

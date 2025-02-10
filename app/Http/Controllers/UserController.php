<?php

namespace App\Http\Controllers;

use App\Models\MainModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use function Symfony\Component\String\s;

class UserController extends Controller
{

    public function __construct()
    {
        $this->data = [];
        $this->data['pageTitle'] = "Dedeoğlu Giyim - ";
        $this->url = "http://dedeoglu.dehapi.com/";
        $categoriurl = $this->url."api/categories";
        $response = Http::get($categoriurl);
        if ($response->successful()){
            $this->data['categories'] = $response['categories'];
        }
    }

    public function register()
    {
        $this->data['countries'] = DB::table('ulkeler')->get();
        return view('User.register', $this->data);
    }
    public function registerPost(Request $request)
    {
        $name = $request->string('name');
        $surname = $request->string('surname');
        $tel = $request->string('tel');
        $email = $request->string('email');
        $password = $request->string('password');
        $password_retry = $request->string('password_retry');
        $country = $request->integer('country');
        $city = $request->integer('city');
        $state = $request->integer('state');
        $address = $request->string('address');
        $neighborhood = $request->string('neighborhood');
        $street = $request->string('street');
        $postal_code = $request->string('postal_code');
        $tax_office = $request->string('tax_office');
        $tax_number = $request->string('tax_number');
        $idtentity_number = $request->integer('identity_number');
        $note = $request->string('note');
        $countries = DB::table('ulkeler')->get();
        if ($password == $password_retry){
            $pswrd = md5(sha1($password));
            foreach ($countries as $c){
                if ($c->id == $country){
                    $country = $c->baslik;
                }
            }
            $cities = DB::table('sehirler')->get();
            foreach ($cities as $sehir) {
                if ($sehir->id == $city){
                    $city = $sehir->baslik;
                }
            }
            $states = DB::table('ilceler')->get();
            foreach ($states as $ilce) {
                if ($ilce->id == $state){
                    $state = $ilce->baslik;
                }
            }
            $url =$this->url."api/register";
            $response = Http::post($url, [
                "identity_number" => $idtentity_number,
                "tax_number"=> $tax_number,
                "tax_office"=> $tax_office,
                "name"=> $name,
                "surname" => $surname,
                "email"=> $email,
                "password"=> $pswrd,
                "phone"=> $tel,
                "address"=> $address,
                "city"=> $city,
                "country"=> $country,
                "district"=> $state,
                "street"=> $street,
                "neighborhood"=> $neighborhood,
                "postal_code"=> $postal_code,
                "note"=> $note
            ]);
            if ($response->successful()) {
                session([
                    'email' => $email,
                    'password' => $pswrd
                ]);
                return redirect()->to(route('user.register.accountActive'));
            } else {
                return redirect()->to(route('user.register'))->withErrors(
                    [
                        'error' => 'Kayıt işlemini şuanda gerçekleştiremiyoruz. Lütfen daha sonra tekrar deneyiniz.'
                    ]
                );
            }
        }
        else{
            return redirect()->to(route('user.register'))->withErrors(
                [
                    'error' => 'Girdiğiniz şifreler uyuşmuyor. Lütfen tekrar deneyiniz.'
                ]
            );
        }
    }

    public function registerAccountActivate(Request $request)
    {
        if ($_POST){
            $code = $request->string('token');
            $url = $this->url."api/activate-account";
            $response = Http::post($url, [
                'token' => $code,
                'email' => session('email'),
                'password' => session('password')
            ]);
            if ($response->successful()){
               session()->flush();
               return redirect()->to(route('user.login'));
            }else{
                $url = $this->url."api/resend-activation-code";
                $response = Http::post($url, [
                    'email' => session('email')
                ]);

                return redirect()->to(route('user.register.accounyActive'))->withErrors(
                    [
                        'info' => 'Yeni kod oluşturulup gönderildi. Tekrar deneyebilirsiniz.'
                    ]);
                }


        }

        return view('User.registeraccountactivate', $this->data);
    }



    public function login()
    {
        $this->data['pageTitle'] .= "Giriş Sayfası";
        return view('User.login', $this->data);
    }
    public function loginPost(Request $request)
    {
        $email = $request->string('email');
        $password = $request->string('password');
        $url = $this->url."api/login";
        $response = Http::post($url, [
            'email' => $email,
            'password' => md5(sha1($password))
        ]);
        if ($response->successful()){
            $res = $response->json();
            session([
                'login' => true,
                'name' => $res['user']['name'],
                'surname' => $res['user']['surname'],
                'token' => $res['token'],
                'tokenType' => $res['tokenType']
            ]);
            return redirect()->to(route('homePage'));
        }else{
            return redirect()->to(route('user.login'))->withErrors([
                'error' => 'Girilen bilgiler ile kayıtlı bir kullanıcı bulunmamaktadır. Lütfen tekrar deneyiniz.'
            ]);
        }

    }
    public function logout()
    {
        $url = $this->url."api/logout";
        $response = Http::post($url, [
            'token' => session('token'),
            'tokenType' => session('tokenType')
        ]);
        if ($response->successful()){
            session()->flush();
            return redirect()->to(route('homePage'));
        }else{
            return redirect()->to(route('homePage'))->withErrors([
                'error' => "Çıkış işlemi sırasında bir hata oluştu"
            ]);
        }
    }







    public function getCities($country_id)
    {
        $cities = DB::table('sehirler')->where('ulke_id', $country_id)->get();
        return response()->json($cities);
    }
    public function getStates($city_id)
    {
        $states = DB::table('ilceler')->where('sehir_id',$city_id)->get();
        return response()->json($states);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\ProfileCompany;
use App\Models\Sosmed;
use App\Models\SubCategory;
use App\Models\Form;
use App\Models\Answer;
use DB;
use Illuminate\Support\Facades\Http;
use SimpleXMLElement;
use Session;
use DateTime;
use GuzzleHttp\Client;

class SiteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       return redirect(route('login'));
    }

    public function auth(){
        $username = 'LHgCXjCutZL8GGp9kG6DkqgUD5Ia';
        $password = 'PUEpzdiQWGjyeVLJqvwmDff2PL4a';
        $send = Http::withBasicAuth($username, $password)->post('https://apimws.bkn.go.id/oauth2/token', [
            'username'      => $username,
            'password'       => $password,
            'grant_type'    => 'client_credentials',
        ]);
        return $send;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

}

<?php

namespace App\Http\Controllers;
use App\Models\Thingsboard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ThingsboardController extends Controller
{
    //Create Index
    public function index(){
        // $data['thingsboard1'] = Thingsboard::OrderBy('id', 'desc')->paginate(5);
        // return view('thingsboard.index',$data);
        // return view('thingsboard.index');
        // $data['thingsboard1']  = DB::connection('mysql')->select("SELECT * FROM `thingsboard`");

        $data['thingsboard'] = DB::connection('pgsql')->select("SELECT *, to_timestamp(ts/1000) AS NewDate ,ts_kv_dictionary.key AS device_name FROM public.ts_kv LEFT JOIN public.ts_kv_dictionary ON ts_kv.key = ts_kv_dictionary.key_id ORDER BY ts DESC LIMIT 10");
        return view('thingsboard.index',$data);

    }
    public function dashboard(){
        
        // $data['thingsboard1'] = Thingsboard::OrderBy('id', 'desc')->paginate(5);
        // return view('thingsboard.index',$data);
        // return view('thingsboard.index');
        // $data['thingsboard1']  = DB::connection('mysql')->select("SELECT * FROM `thingsboard`");

        // $data['thingsboard'] = DB::connection('pgsql')->select("SELECT ts_kv.*, to_timestamp(ts/1000) AS NewDate ,ts_kv_dictionary.key AS device_name FROM public.ts_kv LEFT JOIN public.ts_kv_dictionary ON ts_kv.key = ts_kv_dictionary.key_id ORDER BY ts DESC LIMIT 10");
        // return view('thingsboard.dashboard',$data);
        // return view('thingsboard.index',$data);
        return view('thingsboard.dashboard');


    }
    public function billing(){
        
        // $data['thingsboard1'] = Thingsboard::OrderBy('id', 'desc')->paginate(5);
        // return view('thingsboard.index',$data);
        // return view('thingsboard.index');
        // $data['thingsboard1']  = DB::connection('mysql')->select("SELECT * FROM `thingsboard`");

        $data['thingsboard'] = DB::connection('pgsql')->select("SELECT ts_kv.*, to_timestamp(ts/1000) AS NewDate ,ts_kv_dictionary.key AS device_name FROM public.ts_kv LEFT JOIN public.ts_kv_dictionary ON ts_kv.key = ts_kv_dictionary.key_id ORDER BY ts DESC LIMIT 10");
        return view('thingsboard.billing',$data);
        // return view('thingsboard.index',$data);

    }
}

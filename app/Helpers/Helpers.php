<?php

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

if (!function_exists('app_setting')) {
    /**
     * Récupérer un paramètre depuis la base de données.
     */
    function app_setting($key, $default = null)
    {
        $settings = Cache::rememberForever('app_settings', function () {
            return DB::table('settings')->pluck('value', 'key')->toArray();
        });

        return $settings[$key] ?? $default;
    }
}

if (!function_exists('set_app_setting')) {
    /**
     * Mettre à jour un paramètre dans la base de données.
     */
    function set_app_setting($key, $value)
    {
        DB::table('settings')->updateOrInsert(['key' => $key], ['value' => $value]);
        Cache::forget('app_settings');
    }
}

if(!function_exists('route_is')){
    function route_is($route=null){
        if(Request::routeIs($route)){
            return true;
        }else{
            return false;
        }
    }
}

if(!function_exists('route_is')){
    function route_is($routes=[]){
        foreach($routes as $route){
            if(Request::routeIs($route)){
                return true;
            }else{
                return false;
            }
        }
    }
}

if(!function_exists('notify')){
    function notify($message , $type='success'){
        return array(
            'message'=> $message,
            'alert-type' => $type,
        );
    }
}

if(!function_exists('alert')){
    function alert($message , $type='success'){
        return array(
            'message'=> $message,
            'alert-type' => $type,
        );
    }
}

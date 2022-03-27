<?php

use Illuminate\Support\Arr;
use Illuminate\Support\Str;

if(!function_exists('sendResult')){
    function sendResult($error, $data)
    {
        return (object) [
            'error' => $error,
            'result'  => $data
        ];
    }
}

if(!function_exists('formatRupiah')){
    function formatRupiah($nominal)
    {
        return "Rp. " . number_format($nominal, 2, ',' ,'.');
    }
}

if(!function_exists('arrayWithKey')){
    function arrayWithKey($values, $keys, $key){
        $datas = [];

        for ($i = 0; $i < count($values); $i++) {
            $datas = Arr::prepend(
                $datas,
                $values[$i],
                Str::slug($keys[$i][$key])
            );
        }

        return $datas;
    }
}

if(!function_exists('randColor')){
    function randColor() {
        return '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
    }
}

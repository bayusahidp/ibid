<?php

namespace App\Http\Controllers;

class FilterController extends Controller
{
    public function index()
    {
        $jsonString = file_get_contents(base_path('public/filter.json'));

        $data = json_decode($jsonString, true);
        
        $result = array();
        foreach ($data['data']['response']['billdetails'] as $parse) {
            $denome = explode(':', $parse['body'][0]);
            $value = (int)$denome[1];
            if ($value >= 100000) {
                array_push($result, $value);
            }
        }
        dd($result);
    }
}
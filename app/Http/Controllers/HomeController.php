<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Util\Utils;
use Auth;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('app');
    }

    /**
     * Get initial data for Vue.js application
     */
    public function vue()
    {

        if($this->user()->isAdmin()){
            $homeItems = [
                [
                    'name' => 'strings.users',
                    'icon' => 'b-icon-people-fill',
                    'link' => 'users',
                ],
                [
                    'name' => 'strings.cars',
                    'icon' => 'b-icon-minecart',
                    'link' => 'cars',
                ],
            ];
        }

        if($this->user()->isNormal()){
            $homeItems = [
            [
                'name' => 'strings.cars',
                'icon' => 'b-icon-minecart',
                'link' => 'cars',
            ]
        ];
        }

        $settingsFile = Utils::getSettingsFile();

        $settings = array();

        if (file_exists($settingsFile)) {
            $settings = json_decode(file_get_contents($settingsFile));
        }

        $data = [
            'homeItems' => $homeItems,
            'settings' => $settings,
        ];

        return $data;
    }

    public function user() {
        return Auth::user();
    }
}

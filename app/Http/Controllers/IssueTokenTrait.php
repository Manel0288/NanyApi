<?php
/**
 * Created by PhpStorm.
 * User: djelo bah
 * Date: 16-01-19
 * Time: 23:09
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

trait IssueTokenTrait
{
    public function issueToken(Request $request, $grantType, $scope='*'){
        $params = [
            'grant_type' => $grantType,
            'client_id' => $this->client->id,
            'client_secret' => $this->client->secret,
            'username' => $request->input('username') ?: $request->input('email')
        ];

        $request->request->add($params);
        if ($grantType == "password")
            $proxy = Request::create('api/oauth/token', 'POST');
        else
            $proxy = Request::create('oauth/token', 'POST');

        return Route::dispatch($proxy);
    }
}
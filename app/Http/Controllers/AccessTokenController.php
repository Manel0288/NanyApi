<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use League\OAuth2\Server\Exception\OAuthServerException;
use Psr\Http\Message\ServerRequestInterface;
use Response;
use \Laravel\Passport\Http\Controllers\AccessTokenController as
    ATC;

class AccessTokenController extends ATC
{
    public function issueToken(ServerRequestInterface $request)
    {
        try {
            //get username (default is :email)
            $username = $request->getParsedBody()['username'] ?: $request->getParsedBody()['email'];

            $user = User::where('email', '=', $username)->first();

            //generate token
            $tokenResponse = parent::issueToken($request);

            //convert response to json string
            $content = $tokenResponse->getContent();

            //convert json to array
            $data = json_decode($content, true);

            if(isset($data["error"]))
                throw new OAuthServerException('The user credentials were incorrect.', 6, 'invalid_credentials', 401);

            //add needed user info
            $data['nom'] = $user->nom.' '.$user->prenom;
            $data['email'] = $user->email;
            $data['image_url'] = $user->image_url;
            $data['role'] = $user->role()->first()->statut;

            return Response::json($data);
        }
        catch (ModelNotFoundException $e) { // email not found
            //return error message
            return response(["message" => "User not found"], 500);
        }
        catch (OAuthServerException $e) { //password not correct..token not granted
            //return error message
            return response(["message" => "The user credentials were incorrect.', 6, 'invalid_credentials"], 500);
        }
        catch (Exception $e) {
            ////return error message
            return response(["message" => "Internal server error"], 500);
        }
    }
}

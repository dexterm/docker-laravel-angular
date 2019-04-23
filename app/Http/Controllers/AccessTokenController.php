<?php
//retrieved from https://gist.github.com/messi89/489473c053e3ea8d9e034b0032effb1d
namespace App\Http\Controllers;

use App\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use League\OAuth2\Server\Exception\OAuthServerException;
use Psr\Http\Message\ServerRequestInterface;
use Response;
use Illuminate\Http\Request;

use \Laravel\Passport\Http\Controllers\AccessTokenController as ATC;

class AccessTokenController extends ATC
{
    public function issueToken(ServerRequestInterface $request)
    {

        try {
            //get username (default is :email)
            $username = $request->getParsedBody()['username'];
            //echo $request->getParsedBody()['username'] . $request->getParsedBody()['password'];

            //get user
            //change to 'email' if you want
            $user = User::where('email', '=', $username)->first();

            //generate token
            $tokenResponse = parent::issueToken($request);

            //convert response to json string
            $content = $tokenResponse->getContent();

            //convert json to array
            $data = json_decode($content, true);

            if(isset($data["error"]))
                throw new OAuthServerException('The user credentials were incorrect.', 6, 'invalid_credentials', 401);

            //add access token to user
            $user = collect($user);
            $user->put('access_token', $data['access_token']);
            $user->put('expires_in', $data['expires_in']);
            $user->put('refresh_token', $data['refresh_token']);


            //return Response::json(array($user)); //returns json output as [{name:'XYX,blah}]
            return Response::json($user); //returns json output as {name:'XYX',email:'xyz@whatever.com'}]

        }
        catch (ModelNotFoundException $e) { // email notfound
            //return error message
            return response(["message" => "User not found"], 500);
        }
        catch (OAuthServerException $e) { //password not correct..token not granted
            //return error message
            return response(["message" => "The user credentials are incorrect."], 401);
        }
        catch (Exception $e) {
            ////return error message
            return response(["message" => "Internal server error"], 500);
        }
    }
}

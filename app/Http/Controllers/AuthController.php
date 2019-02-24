<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Laravel\Passport\Client as OAuthClient;
use App\Transformers\Json;

class AuthController extends Controller
{

    public function login(Request $request){
        $http = new Client();

        $client = OAuthClient::wherePasswordClient(true)->whereRevoked(false)->first();
        $client_id = $client->id;
        $client_secret = $client->secret;

        $response = $http->post('api.forum.test/oauth/token', [
            'form_params' => [
                'grant_type' => 'password',
                'client_id' => $client_id,
                'client_secret' => $client_secret,
                'username' => $request->email,
                'password' => $request->password,
                'scope' => '',
            ],
        ]);

        return json_decode((string) $response->getBody(), true);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);            
        }

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        return json::response($user,'Registration Success');
    }

    public function details()
    {
        $user = Auth::user();
        return json::response($user);;
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return json::response('','Logout Success');
    }
}

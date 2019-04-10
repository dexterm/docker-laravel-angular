<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;

class VerifyOAuthController extends Controller
{
    /**
     * Send back all comments as JSON
     *
     * @return Response
     */
    public function index()
    {
      return Response::json(Comment::get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $host = "http://192.168.32.1/register";
        Log::info("Showing user profile for user: $host ");

        $client = new \GuzzleHttp\Client(['timeout'  => 2000.0]);
        $response = $client->request('POST', $host, [
            'form_params' => [
                'name' => 'Dexter McConnell',
                'email' => 'djcm95@gmail.com',
                'password' => 'sunridge',
                'c_password' => 'sunridge',
                'mobile' => '111111111111111'
            ]
        ]);
        $response = $response->getBody()->getContents();
        //echo '<pre>';
        //print_r($response);
        return Response::json(array('success' => true));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        Comment::destroy($id);

        return Response::json(array('success' => true));
    }

}



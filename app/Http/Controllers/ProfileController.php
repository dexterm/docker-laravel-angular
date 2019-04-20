<?php

namespace App\Http\Controllers;

use App\User;
use Auth;
use Bican\Roles\Models\Permission;
use Bican\Roles\Models\Role;
use Hash;
use Illuminate\Http\Request;
use Input;
use Validator;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
  //  use HasApiTokens, Notifiable;
/*
*{"id":1,"name":"DEXTER MCCONNELL","email":"djcm95@gmail.com","created_at":"2019-04-18 10:39:26","updated_at":"2019-04-18 10:39:26","social":"110093864950185640373","social_type":"google","avatar":"https:\/\/lh5.googleusercontent.com\/-4jWMMbSlscU\/AAAAAAAAAAI\/AAAAAAAAAAA\/yf74DiBjjn4\/s50\/photo.jpg","access_token":"eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjJmZTYzZmRlNjU4ZWY0NWY3MjM1OWYxNDU1ZjU1YWNkN2E3NjhhZTEzNjY5MGMwNGU1YjUzMDdhMDE5MjRhYzAwZGZlYjg5MzRiYzQzMjFjIn0.eyJhdWQiOiIxIiwianRpIjoiMmZlNjNmZGU2NThlZjQ1ZjcyMzU5ZjE0NTVmNTVhY2Q3YTc2OGFlMTM2NjkwYzA0ZTViNTMwN2EwMTkyNGFjMDBkZmViODkzNGJjNDMyMWMiLCJpYXQiOjE1NTU3MDMxOTUsIm5iZiI6MTU1NTcwMzE5NSwiZXhwIjoxNTU1NzAzNDk1LCJzdWIiOiIxIiwic2NvcGVzIjpbIioiXX0.oUR4Lai_64JbncQcO3nupe7P95zR0rrIrP9nNGdJG_ng2RLGQJwJDF10nSdp6JfGqXHkTinV7Gal5YIgvoG0cvRh_aZ5Y7wInV8T7aBPxU8F1xVBMfI9wqP6tyyla-lALlIidArpJ3X11qVPU_-CwEJjPwO8AT08vUCfs8ro2jnP8H2aXhp4hgD2sZOoHiapgwqRXxRF7p48ae9sAkCLeY6UZy5CJQIaMIOv1MT6vKYCiDvJx-yTn80cFD7adQQjkiCklMvHQ257BXaylqUqbeFlZOs-eIyR3GJh2qPARL6oODhxBg7WSLNR5R6VEbz-soO1cAabHQzwXx07EGjZOl1KDlQXI7NmFO9gtMqRxNopu2n6t0H8gRpcViBYtCksea97ZeS3d4LxI9rHLTE_DIWzyABOB0vIccN40UzFhEBXqp0M4KroIShu2QCtR3KzyxefAf-TV9zfi2WA3uGgzMVB65waCmRKBHrBDkX4WeiUDh5DH3QpG4HKj9CPhQyv9eDNp0whSOfM41p1lIX6hBxT8MbUlEChEJM_HtLmJzzi_ddqypdi7ClccZ0NrTNKiPy1T6B_W8vSmNqRHfCZtLby8qzPa-s37mK6dbvZxwoC_GIMjmTlA4CHxAqRW-a8ByrqejzT-6W2qgu76JJJfrRKuK7Zkdaax7ZmsFGm5o8","expires_in":299,"refresh_token":"def5020094790d03b048dcdd6775474512f08eef3844f759be1a9043b105644b42e2626385ae753467abc9c42e9606543f10657f0ae16d16908c3b28821d582cd977b5e21c0d28d58b1208fd753c0e487abf1d9af0436fed5bc475a7a9e400edfa14f4866a44fcfff2c37219ebb2022495f718ee99c05d30e92cea33486600eba002d1c6fe90c8946cddeff61aa6b3e3a9a38dd7e19931d0cbf4f7e6c71452b6cfb6f17ec08a09a3b0dc91c11828cc2b228877e85cd6bd6efe9482d451fda98b7c06b20c94561ef737db9a06c787ad5ff2afe37ae88a34e06eb41661e6d5cb3abf154fc73787447d52fe48ff5fcf35a9f1574702c51ceeb2ac95f6efe07b886623f196c067395696b0d4723ff14e31f3ee4d4b68c9ed342e3513fc66f2d192380b03e683ad3c67ca45ed8f6aa10c4de8d810bb4763ca76869684d8e5709359d8dbfb6c524eeeee685942e5eefb8ea72a79cb2e53a90548a78ddac81aca7ed7beeb4abb15"}
*/
    /**
     * Get user current context.
     *
     * @return JSON
     */
    public function getMe()
    {
      Log::info('Fetching profile details.... ');
        try {
          $user = Auth::user();

          //return response()->success($user);
          //return response()->json(['success' => $user], $this-> successStatus);
          return response()->json($user, 200);
        }
        catch (OAuthServerException $e) { //password not correct..token not granted
            //return error message
            Log::error("Invalid token", $e->getMessage() );

            return response(["message" => "The user credentials were incorrect.', 6, 'invalid_credentials"], 500);
        }
        catch (Exception $e) {
            ////return error message
            Log::error("Invalid token", $e->getMessage() );
            return response(["message" => "Internal server error"], 500);
        }

    }

    /**
     * Update user current context.
     *
     * @return JSON success message
     */
    public function putMe(Request $request)
    {
        $user = Auth::user();

        $this->validate($request, [
            'data.name' => 'required|min:3',
            'data.email' => 'required|email|unique:users,email,'.$user->id,
        ]);

        $userForm = app('request')
                    ->only(
                        'data.current_password',
                        'data.new_password',
                        'data.new_password_confirmation',
                        'data.name',
                        'data.email'
                    );

        $userForm = $userForm['data'];
        $user->name = $userForm['name'];
        $user->email = $userForm['email'];

        if ($request->has('data.current_password')) {
            Validator::extend('hashmatch', function ($attribute, $value, $parameters) {
                return Hash::check($value, Auth::user()->password);
            });

            $rules = [
                'data.current_password' => 'required|hashmatch:data.current_password',
                'data.new_password' => 'required|min:8|confirmed',
                'data.new_password_confirmation' => 'required|min:8',
            ];

            $payload = app('request')->only('data.current_password', 'data.new_password', 'data.new_password_confirmation');

            $messages = [
                'hashmatch' => 'Invalid Password',
            ];

            $validator = app('validator')->make($payload, $rules, $messages);

            if ($validator->fails()) {
                return response()->error($validator->errors());
            } else {
                $user->password = Hash::make($userForm['new_password']);
            }
        }

        $user->save();

        return response()->success('success');
    }

    /**
     * Get all users.
     *
     * @return JSON
     */
    public function getIndex()
    {
        $users = User::all();

        return response()->success(compact('users'));
    }

    /**
     * Get user details referenced by id.
     *
     * @param int User ID
     *
     * @return JSON
     */
    public function getShow($id)
    {
        $user = User::find($id);
        $user['role'] = $user
                        ->roles()
                        ->select(['slug', 'roles.id', 'roles.name'])
                        ->get();

        return response()->success($user);
    }



}

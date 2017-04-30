<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;
use Mockery\Exception;
use Illuminate\Support\Facades\Log;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return Response
     */
    public function redirectToProvider(){
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return Response
     */
    public function handleProviderCallback(){

        try{
            $socialUser = Socialite::driver('facebook')->user();
//            dd($socialUser);

        }
        catch (Exception $e){
            return redirect('/');
        }
        $user=User::where('facebook_id',$socialUser->getId())->first();

        if (!$user){
            $user=new User;

            $user->facebook_id=$socialUser->id;
            $user->name=$socialUser->name;
            $user->email=$socialUser->email ? $socialUser->email : "noemail@example.com";
            $user->avatar=$socialUser->avatar_original;
            $user->remember_token=$socialUser->token;

            $user->save();
        };
        auth()->login($user);
        return redirect()->to(route('home'));
    }

    /**
     *Input Request
     * Deactivate user when he delete app from fb
     */
    public function deactivateUser(Request $request){

        $data=$this->parse_signed_request($request->signed_request);
        $user=User::where('facebook_id',$data['user_id'])->first();
        $user->is_active=false;
        $user->save();

    }

    /**
     * @param $signed_request
     * @return mixed|null
     */
    private function parse_signed_request($signed_request) {
        list($encoded_sig, $payload) = explode('.', $signed_request, 2);

        $secret = "8dc4b51e15db6e08e0fae7a0308d7160"; // Use your app secret here

        // decode the data
        $sig = $this->base64_url_decode($encoded_sig);
        $data = json_decode($this->base64_url_decode($payload), true);

        // confirm the signature
        $expected_sig = hash_hmac('sha256', $payload, $secret, $raw = true);
        if ($sig !== $expected_sig) {
            error_log('Bad Signed JSON signature!');
            return null;
        }

        return $data;
    }

    /**
     * @param $input
     * @return bool|string
     */
    private function base64_url_decode($input) {
        return base64_decode(strtr($input, '-_', '+/'));
    }
}

<?php

namespace App\Http\Controllers\Auth;


use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
// added facades
use DB;
use Mail;
use App\Role;
use Illuminate\Http\Request;
use App\Mail\EmailVerification;


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
    protected $redirectTo = '/';

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
     * @return \App\User
     */
    protected function create(array $data)
    {

        $role = Role::where('name', 'player')->first();
        
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'token' => str_random(10),
            ]);
        
        $user->assignRole($role);

        return $user;

    }

    /**
    *  Over-ridden the register method from the "RegistersUsers" trait
    *  Remember to take care while upgrading laravel
    */
    protected function register(Request $request)
    {

        // Laravel validation
        $validator = $this->validator($request->all());

        if ($validator->fails())
        {

            $this->throwValidationException($request, $validator);

        }

        DB::beginTransaction();

        try
        {

            $user = $this->create($request->all());

            // After creating the user send an email with the random token generated in the create method above
            $email = new EmailVerification(new User(['token' => $user->token, 'name' => $user->name]));

            Mail::to($user->email)->send($email);
            
            DB::commit();

            \Session::flash('message', 'We have sent you a verification email!');
            return back();

        }

        catch(Exception $e)
        {
            DB::rollback(); 
            return back();
        }

    }

    public function verify($token)
    {
    // The verified method has been added to the user model and chained here
    // for better readability
        User::where('token',$token)->firstOrFail()->verified();
        return redirect('login');
    }
}

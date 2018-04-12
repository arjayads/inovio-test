<?php

namespace App\Http\Controllers\Auth;

use App\Charge;
use App\Plan;
use App\User;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

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
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'plan_id' => $data['plan'],
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $plan = Plan::find($data['plan']);

        $month = array_search($data['month'], $this->month());
        $month = str_pad($month, 2, '0', STR_PAD_LEFT);

        $chargeData = [
            'cust_fname' => $data['name'],
            'cust_email' => $data['email'],
            'li_prod_id_1' => $plan->gateway_id,
            'li_value_1' => $plan->first_charge+0,
            'li_count_1' => 1,
            'pmt_numb' => $data['card'],
            'pmt_key' => $data['cvc'],
            'pmt_expiry' => $month.'/'.$data['year'],
        ];


//        $response = $user->charge($chargeData);
        $response = $user->subscribe($user->plan_id, $chargeData);

        if($response) {

            // save charges
            Charge::create([
                'user_id' => $user->id,
                'trans_datetime' => Carbon::now(),
                'amount' => $response['charge']['TRANS_VALUE'] + 0,
                'data' => json_encode($response['charge']),
            ]);

            return $user;

        } else {
            $user->delete();
        }
    }

    private function month() {
        $info = cal_info(0);
        return $info['months'];
    }
}

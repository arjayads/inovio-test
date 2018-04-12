<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function accountClosed() {
        return view('account-closed');
    }
    public function closeAccount()
    {
        $user = auth()->user();

        $sub = $user->cancelSubscription($user->plan_id);

        if($sub) {

            $user->closed_on = Carbon::now();
            $user->close_reason = 'website';

            $user->save();

            Auth::logout();

            return redirect('/account-closed');

        } else {
            abort(404);
        }
    }
}

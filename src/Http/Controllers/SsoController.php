<?php


namespace Cblink\Sso\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Validation\ValidatesRequests;

class SsoController extends Controller
{

    use AuthenticatesUsers, ValidatesRequests;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    public function getTicket(Request $request)
    {
        if (DB::table(config('sso.table'))->where([
            'app_id' => $appId = $request->get('app_id'),
            'secret' => $request->get('secret'),
        ])->exists()) {
            $ticket = str_random(64);

            Cache::put($ticket, $appId, 5);

            return ['ticket' => $ticket];
        } else {
            return ['error' => 'invalid auth'];
        }
    }

    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            'ticket' => 'required|string',
        ]);
    }

    protected function credentials(Request $request)
    {
        return $request->only('ticket');
    }

    protected function guard()
    {
        return Auth::guard(config('sso.guard', 'web'));
    }
}
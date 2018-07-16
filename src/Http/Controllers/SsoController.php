<?php


namespace Cblink\Sso\Http\Controllers;


use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

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
            logger(Cache::get($ticket));

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
}
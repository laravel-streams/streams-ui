<?php

namespace Streams\Ui\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class Logout extends Controller
{
    public function __invoke()
    {
        Auth::logout();

        Session::invalidate();
        Session::regenerateToken();

        return Redirect::to(Request::input('redirect', URL::to('/')));
    }
}

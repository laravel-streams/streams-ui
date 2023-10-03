<?php

namespace Streams\Ui\Components\Admin;

use Streams\Ui\Support\Component;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request;
use Streams\Core\Support\Facades\Messages;
use Streams\Core\Support\Facades\Streams;
use Streams\Ui\Components\Traits\HasAttributes;

class AdminLogin extends Component
{
    use HasAttributes;

    public array $attributes = [];

    public string $template = 'ui::components.admin.login';

    function login(): RedirectResponse
    {
        $user = Streams::repository('users')->findBy('email', Request::input('email'));

        if (!$user) {
            Messages::error('Invalid email or password.');
        }

        if ($user && Hash::check(Request::input('password'), $user->password)) {
            Auth::login($user);
            return redirect('/admin');
        } else {
            Messages::error('Invalid email or password.');
        }

        return redirect('/login');
    }
}

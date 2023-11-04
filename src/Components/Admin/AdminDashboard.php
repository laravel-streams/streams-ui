<?php

namespace Streams\Ui\Components\Admin;

use Streams\Ui\Components\Admin;

class AdminDashboard extends Admin
{
    public function render()
    {
        return view('ui::components.admin.dashboard');
    }
}

<?php

namespace App\Controllers;

use App\Models\UserModel;

class Login extends BaseController
{
    public function index()
    {
        return view('login');
    }

    public function submit()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $user = (new UserModel())->where('username', $username)->first();

        if ($user === null || ! password_verify($password, $user['password'])) {
            return redirect()->to('/login')
                ->with('error', 'Invalid login.');
        }

        session()->regenerate(true);
        session()->set('staff_id', (int) $user['id']);

        return redirect()->to('/products');
    }

    public function logout()
    {
        session()->destroy();

        return redirect()->to('/login');
    }
}

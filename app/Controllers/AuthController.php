<?php

namespace App\Controllers;

use App\Models\UserModel;

class AuthController extends BaseController
{
    public function index()
    {
        $page = [
            'brand' => 'TERRA NOVA',
            'heroPosition' => 'center',
            'images' => [
                'hero' => base_url('assets/images/hero.jpg'),
                'background' => base_url('assets/images/background.jpg')
            ],
            'links' => [
                'linkedin' => '#',
                'instagram' => '#'
            ],
            'loginUrl' => base_url('login'),
            'csrf' => csrf_hash(),
            'csrfToken' => csrf_token()
        ];

        $db = \Config\Database::connect();

        $services = $db->table('services')
            ->select('id, name')
            ->orderBy('name', 'ASC')
            ->get()
            ->getResultArray();

        return view('auth/login', [
            'page' => $page,
            'services' => $services
        ]);
    }

    public function login()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $userModel = new UserModel();

        $user = $userModel->where('email', $email)->first();

        if (!$user || !password_verify($password, $user['password_hash'])) {
            return redirect()->to('/login');
        }

        $db = \Config\Database::connect();

        $role = $db->table('roles')
            ->where('id', $user['role_id'])
            ->get()
            ->getRowArray();

        session()->regenerate();

        session()->set([
            'user_id'   => $user['id'],
            'name'      => $user['name'],
            'role'      => $role['code'],
            'logged_in' => true
        ]);

        if ($role['code'] === 'admin') {
            return redirect()->to('/admin');
        }

        if ($role['code'] === 'agent') {
            return redirect()->to('/agent');
        }

        return redirect()->to('/citoyen');
    }

    public function register()
    {
        if ($this->request->getMethod() === 'GET') {
            return view('auth/register');
        }

        $validation = [
            'name'     => 'required|min_length[2]',
            'email'    => 'required|valid_email',
            'password' => 'required|min_length[8]'
        ];

        if (!$this->validate($validation)) {
            return redirect()->to('/register');
        }

        $name = $this->request->getPost('name');
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $userModel = new UserModel();

        $existingUser = $userModel->where('email', $email)->first();

        if ($existingUser) {
            return redirect()->to('/register');
        }

        $userModel->insert([
            'role_id'       => 3,
            'name'          => $name,
            'email'         => $email,
            'password_hash' => password_hash($password, PASSWORD_DEFAULT)
        ]);

        return redirect()->to('/login');
    }

    public function registerAgent()
    {
        if ($this->request->getMethod() === 'GET') {
            return redirect()->to('/login');
        }

        $validation = [
            'name'       => 'required|min_length[2]',
            'email'      => 'required|valid_email',
            'password'   => 'required|min_length[8]',
            'service_id' => 'required|is_natural_no_zero'
        ];

        if (!$this->validate($validation)) {
            return redirect()->to('/login');
        }

        $name      = $this->request->getPost('name');
        $email     = $this->request->getPost('email');
        $password  = $this->request->getPost('password');
        $serviceId = $this->request->getPost('service_id');

        $userModel = new UserModel();

        $existingUser = $userModel->where('email', $email)->first();

        if ($existingUser) {
            return redirect()->to('/login');
        }

        $userModel->insert([
            'role_id'       => 2,
            'service_id'    => $serviceId,
            'name'          => $name,
            'email'         => $email,
            'password_hash' => password_hash($password, PASSWORD_DEFAULT)
        ]);

        return redirect()->to('/login');
    }

    public function logout()
    {
        session()->destroy();

        return redirect()->to('/login');
    }
}

<?php

namespace App\Controllers\Citizen;

use App\Controllers\BaseController;
use App\Models\UserModel;

class ProfileController extends BaseController
{
    /** GET /citoyen/profile  (D12) */
    public function show()
    {
        $user = (new UserModel())->find((int) session()->get('user_id'));

        return view('citizen/profile', [
            'title'  => 'Mon profil',
            'crumbs' => [['Accueil', '/citoyen'], ['Mon profil', null]],
            'user'   => $user,
        ]);
    }

    /** POST /citoyen/profile */
    public function update()
    {
        if (! $this->validate(['name' => 'required|min_length[2]|max_length[150]'])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $name = $this->request->getPost('name');
        (new UserModel())->update((int) session()->get('user_id'), ['name' => $name]);
        session()->set('name', $name);

        return redirect()->to('/citoyen/profile')->with('success', 'Profil mis à jour.');
    }
}

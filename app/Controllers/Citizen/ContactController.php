<?php

namespace App\Controllers\Citizen;

use App\Controllers\BaseController;
use App\Models\CitizenContactModel;

class ContactController extends BaseController
{
    /** GET /citoyen/contact  (D04) */
    public function create()
    {
        return view('citizen/contact/new', [
            'title'  => 'Contacter la mairie',
            'crumbs' => [['Accueil', '/citoyen'], ['Contact', null]],
        ]);
    }

    /** POST /citoyen/contact */
    public function store()
    {
        $rules = ['message' => 'required|min_length[10]|max_length[2000]'];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        (new CitizenContactModel())->insert([
            'user_id' => (int) session()->get('user_id'),
            'message' => $this->request->getPost('message'),
            'status'  => 'nouveau',
        ]);

        return redirect()->to('/citoyen/contact')
            ->with('success', 'Votre message a bien été envoyé aux services municipaux.');
    }
}

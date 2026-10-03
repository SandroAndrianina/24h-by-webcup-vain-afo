<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class CitoyenController extends BaseController
{
    public function index()
    {
        return "Accueil Citoyen";
    }

    public function requests()
{
    $userId = session()->get('user_id');
    $model = new \App\Models\ContactMessageModel();
    $requests = $model->forCitizen($userId);

    return view('citizen/requests/index', [
        'title'    => 'Mes demandes',
        'requests' => $requests,
    ]);
}

public function newRequest()
{
    return view('citizen/requests/create', ['title' => 'Nouvelle demande']);
}

public function createRequest()
{
    $payload = $this->request->getPost();

    $rules = [
        'subject' => 'required|max_length[200]',
        'message' => 'required|min_length[10]|max_length[2000]',
    ];

    if (! $this->validate($rules)) {
        return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
    }

    $model = new \App\Models\ContactMessageModel();
    $id = $model->insert([
        'user_id'  => session()->get('user_id'),
        'type'     => 'demande',
        'subject'  => $payload['subject'],
        'message'  => $payload['message'],
        'location' => $payload['location'] ?? null,
        'status'   => 'nouveau',
    ]);

    return redirect()->to('/citoyen/requests/' . $id)
        ->with('success', 'Votre demande a bien été envoyée.');
}

public function showRequest($id = null)
{
    $userId = session()->get('user_id');
    $model = new \App\Models\ContactMessageModel();
    $request = $model->findForCitizen((int) $id, $userId);

    if (! $request) {
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
    }

    return view('citizen/requests/show', [
        'title'   => 'Demande #' . $id,
        'request' => $request,
    ]);
}
}

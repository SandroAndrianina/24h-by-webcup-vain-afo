<?php

namespace App\Controllers\Citizen;

use App\Controllers\BaseController;
use App\Models\CitizenRequestModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class RequestController extends BaseController
{
    private function userId(): int
    {
        return (int) session()->get('user_id');
    }

    /** GET /citoyen/requests  (D11 + F26) */
    public function index()
    {
        return view('citizen/requests/index', [
            'title'    => 'Mes demandes',
            'crumbs'   => [['Accueil', '/citoyen'], ['Mes demandes', null]],
            'requests' => (new CitizenRequestModel())->forUser($this->userId()),
        ]);
    }

    /** GET /citoyen/requests/new  (F25) */
    public function create()
    {
        return view('citizen/requests/new', [
            'title'  => 'Nouvelle demande',
            'crumbs' => [['Accueil', '/citoyen'], ['Mes demandes', '/citoyen/requests'], ['Nouvelle demande', null]],
        ]);
    }

    /** POST /citoyen/requests  (F25 + D16) */
    public function store()
    {
        $rules = [
            'type'        => 'required|in_list[' . implode(',', array_keys(CitizenRequestModel::TYPES)) . ']',
            'title'       => 'required|min_length[3]|max_length[150]',
            'description' => 'required|min_length[10]|max_length[2000]',
            'location'    => 'required|min_length[3]|max_length[255]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $id = (new CitizenRequestModel())->insert([
            'user_id'     => $this->userId(),
            'type'        => $this->request->getPost('type'),
            'title'       => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'location'    => $this->request->getPost('location'),
            'status'      => 'nouveau',
        ]);

        // D16 : confirmation immediate apres l'envoi
        return redirect()->to('/citoyen/requests/' . $id)
            ->with('success', 'Votre demande n°' . $id . ' a bien été envoyée. Vous pouvez suivre son avancement ici.');
    }

    /** GET /citoyen/requests/{id}  (D11 detail + suivi) */
    public function show($id = null)
    {
        $req = (new CitizenRequestModel())->findForUser((int) $id, $this->userId());

        if (! $req) {
            throw PageNotFoundException::forPageNotFound();
        }

        return view('citizen/requests/show', [
            'title'   => 'Demande n°' . $req['id'],
            'crumbs'  => [['Accueil', '/citoyen'], ['Mes demandes', '/citoyen/requests'], ['Demande n°' . $req['id'], null]],
            'request' => $req,
        ]);
    }
}

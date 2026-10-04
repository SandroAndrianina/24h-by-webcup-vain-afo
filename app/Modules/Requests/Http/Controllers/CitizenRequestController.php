<?php
namespace App\Modules\Requests\Http\Controllers;

use App\Controllers\BaseController;
use App\Modules\Requests\Application\ListCitizenRequests;
use App\Modules\Requests\Application\SubmitRequest;
use App\Modules\Requests\Infrastructure\RequestRepository;

class CitizenRequestController extends BaseController
{
    public function index()
    {
        $userId = session()->get('user_id');
        $items = (new ListCitizenRequests())->execute($userId);

        return view('citizen/requests/index', [
            'title' => 'Mes demandes',
            'items' => $items,
        ]);
    }

    public function create()
    {
        return view('citizen/requests/create', ['title' => 'Nouvelle demande']);
    }

    public function store()
    {
        $rules = [
            'subject' => 'required|max_length[200]',
            'message' => 'required|min_length[10]|max_length[2000]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $id = (new SubmitRequest())->execute(
            session()->get('user_id'),
            $this->request->getPost()
        );

        return redirect()->to("/citoyen/requests/$id")
            ->with('success', 'Demande envoyée !');
    }

    public function show($id = null)
    {
        $userId = session()->get('user_id');
        $item = (new RequestRepository())->findOneForCitizen((int) $id, $userId);

        if (! $item) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return view('citizen/requests/show', [
            'title' => 'Demande #' . $id,
            'item'  => $item,
        ]);
    }
}
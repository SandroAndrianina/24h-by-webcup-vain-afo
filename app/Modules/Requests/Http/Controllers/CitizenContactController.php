<?php

namespace Modules\Requests\Http\Controllers;

use App\Controllers\BaseController;
use Modules\Requests\Infrastructure\RequestModel;

class CitizenContactController extends BaseController
{
    public function new()
    {
        return view('citizen/contact/new');
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

        $model = new RequestModel();
        $id = $model->insert([
            'user_id'           => (int) session()->get('user_id'),
            'type'              => 'contact',
            'subject'           => trim((string) $this->request->getPost('subject')),
            'message'           => trim((string) $this->request->getPost('message')),
            'status'            => 'nouveau',
            'assigned_agent_id' => null,
        ]);

        return redirect()->to(site_url('citoyen/contact'))
            ->with('success', 'Votre message a bien été envoyé. Référence : #' . $id);
    }
}

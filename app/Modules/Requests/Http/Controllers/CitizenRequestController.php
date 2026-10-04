<?php

namespace Modules\Requests\Http\Controllers;

use App\Controllers\BaseController;
use Modules\Requests\Application\DTOs\SubmitRequestDTO;
use Modules\Requests\Application\ListCitizenRequests;
use Modules\Requests\Application\SubmitRequest;
use Modules\Requests\Application\TrackRequest;
use Modules\Requests\Domain\ValueObjects\RequestType;
use Modules\Requests\Infrastructure\RequestModel;
use Modules\Requests\Infrastructure\RequestRepository;

class CitizenRequestController extends BaseController
{
    private function repo(): RequestRepository
    {
        return new RequestRepository(new RequestModel());
    }

    private function citizenId(): int
    {
        return (int) session()->get('user_id');
    }

    /** F26 — Historique des demandes du citoyen */
    public function index()
    {
        $requests = (new ListCitizenRequests($this->repo()))->execute($this->citizenId());

        return view('Modules/Requests/citizen_index', [
            'requests' => $requests,
        ]);
    }

    /** F25 — Formulaire de création */
    public function new()
    {
        return view('Modules/Requests/citizen_new', [
            'types' => RequestType::all(),
        ]);
    }

    /** F25 — Enregistrement */
    public function store()
    {
        $rules = [
            'type'        => 'required|in_list[lampadaire,voirie,eau,dechets,espace_vert,autre]',
            'description' => 'required|min_length[10]',
            'location'    => 'permit_empty|max_length[255]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        try {
            $dto = new SubmitRequestDTO(
                $this->citizenId(),
                $this->request->getPost('type'),
                $this->request->getPost('description'),
                $this->request->getPost('location') ?: null,
                $this->request->getPost('service_id') ? (int) $this->request->getPost('service_id') : null,
            );

            $request = (new SubmitRequest($this->repo()))->execute($dto);

            return redirect()->to(site_url('citoyen/requests/' . $request->id()))
                             ->with('success', 'Votre demande a bien été enregistrée.');
        } catch (\Throwable $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    /** D11 — Détail + suivi */
    public function show(int $id)
    {
        try {
            $request = (new TrackRequest($this->repo()))->execute($id, $this->citizenId());
        } catch (\Throwable $e) {
            return redirect()->to(site_url('citoyen/requests'))->with('error', $e->getMessage());
        }

        return view('Modules/Requests/citizen_show', [
            'request' => $request,
        ]);
    }
}
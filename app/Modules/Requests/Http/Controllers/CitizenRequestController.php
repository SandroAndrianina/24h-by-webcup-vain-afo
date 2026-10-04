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
            'stats'    => $this->buildStats($requests),
        ]);
    }

    /**
     * Agrégats réels servant aux cartes et graphiques du tableau citoyen.
     *
     * @param  \Modules\Requests\Domain\Entities\Request[] $requests
     * @return array<string, mixed>
     */
    private function buildStats(array $requests): array
    {
        $months = 6;
        $short  = ['jan', 'fév', 'mar', 'avr', 'mai', 'jun', 'jul', 'aoû', 'sep', 'oct', 'nov', 'déc'];

        $statusCounts = ['nouveau' => 0, 'en_cours' => 0, 'resolu' => 0];
        $typeCounts   = [];
        $series       = [];
        $labels       = [];
        $index        = [];

        for ($i = $months - 1; $i >= 0; $i--) {
            $key           = date('Y-m', strtotime("-{$i} months"));
            $index[$key]   = $months - 1 - $i;
            $labels[]      = $short[(int) date('n', strtotime("-{$i} months")) - 1];
            $series[]      = 0;
        }

        foreach ($requests as $request) {
            $status = $request->status()->value();
            $statusCounts[$status] = ($statusCounts[$status] ?? 0) + 1;

            $label = $request->type()->label();
            $typeCounts[$label] = ($typeCounts[$label] ?? 0) + 1;

            $month = substr((string) $request->createdAt(), 0, 7);
            if (isset($index[$month])) {
                $series[$index[$month]]++;
            }
        }

        arsort($typeCounts);

        $total    = count($requests);
        $resolved = $statusCounts['resolu'] ?? 0;

        return [
            'total'    => $total,
            'statuses' => [
                ['label' => 'Nouveau',  'value' => $statusCounts['nouveau'] ?? 0, 'color' => '#df9830'],
                ['label' => 'En cours', 'value' => $statusCounts['en_cours'] ?? 0, 'color' => '#3b82f6'],
                ['label' => 'Résolu',   'value' => $resolved,                   'color' => '#10b981'],
            ],
            'types'     => array_map(
                static fn (string $label, int $count): array => ['label' => $label, 'count' => $count],
                array_keys($typeCounts),
                array_values($typeCounts)
            ),
            'timeline'  => ['labels' => $labels, 'series' => $series],
            'rate'      => $total > 0 ? (int) round($resolved / $total * 100) : 0,
        ];
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
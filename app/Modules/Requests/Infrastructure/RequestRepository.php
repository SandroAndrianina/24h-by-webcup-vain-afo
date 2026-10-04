<?php

namespace Modules\Requests\Infrastructure;

use Modules\Requests\Domain\Entities\Request;
use Modules\Requests\Domain\Repositories\RequestRepositoryInterface;
use Modules\Requests\Domain\ValueObjects\RequestStatus;
use Modules\Requests\Domain\ValueObjects\RequestType;

class RequestRepository implements RequestRepositoryInterface
{
    public function __construct(private RequestModel $model) {}

    public function save(Request $request): Request
    {
        $data = [
            'citizen_id'  => $request->citizenId(),
            'service_id'  => $request->serviceId(),
            'type'        => $request->type()->value(),
            'description' => $request->description(),
            'location'    => $request->location(),
            'status'      => $request->status()->value(),
            'agent_id'    => $request->agentId(),
        ];

        if ($request->id() === null) {
            $id = $this->model->insert($data);
            return $request->withId((int) $id);
        }

        $this->model->update($request->id(), $data);
        return $request;
    }

    public function findById(int $id): ?Request
    {
        $row = $this->model->find($id);

        return $row ? $this->hydrate($row) : null;
    }

    /** @return Request[] */
    public function findByCitizen(int $citizenId): array
    {
        $rows = $this->model
            ->where('citizen_id', $citizenId)
            ->orderBy('created_at', 'DESC')
            ->findAll();

        return array_map(fn($row) => $this->hydrate($row), $rows);
    }

    /** @return Request[] */
    public function findAll(): array
    {
        $rows = $this->model
            ->orderBy('created_at', 'DESC')
            ->findAll();

        return array_map(fn($row) => $this->hydrate($row), $rows);
    }

    /** @return Request[] */
    public function findByService(int $serviceId): array
    {
        $rows = $this->model
            ->where('service_id', $serviceId)
            ->orderBy('created_at', 'DESC')
            ->findAll();

        return array_map(fn($row) => $this->hydrate($row), $rows);
    }

    public function countByService(int $serviceId): int
    {
        return $this->model
            ->where('service_id', $serviceId)
            ->countAllResults();
    }

    public function countByServiceAndStatus(int $serviceId, string $status): int
    {
        return $this->model
            ->where('service_id', $serviceId)
            ->where('status', $status)
            ->countAllResults();
    }

    public function getLastSevenDaysStats(int $serviceId): array
    {
        $stats = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = date('Y-m-d', strtotime("-$i days"));

            $total = $this->model
                ->where('service_id', $serviceId)
                ->where('created_at >=', $date . ' 00:00:00')
                ->where('created_at <=', $date . ' 23:59:59')
                ->countAllResults();

            $nouveau = $this->model
                ->where('service_id', $serviceId)
                ->where('status', 'nouveau')
                ->where('created_at >=', $date . ' 00:00:00')
                ->where('created_at <=', $date . ' 23:59:59')
                ->countAllResults();

            $enCours = $this->model
                ->where('service_id', $serviceId)
                ->where('status', 'en_cours')
                ->where('created_at >=', $date . ' 00:00:00')
                ->where('created_at <=', $date . ' 23:59:59')
                ->countAllResults();

            $resolu = $this->model
                ->where('service_id', $serviceId)
                ->where('status', 'resolu')
                ->where('created_at >=', $date . ' 00:00:00')
                ->where('created_at <=', $date . ' 23:59:59')
                ->countAllResults();

            $stats[] = [
                'date' => date('d/m', strtotime($date)),
                'total' => $total,
                'nouveau' => $nouveau,
                'en_cours' => $enCours,
                'resolu' => $resolu,
            ];
        }

        return $stats;
    }

    public function updateStatus(int $id, string $status, ?int $agentId = null): bool
    {
        $data = [
            'status' => $status
        ];

        if ($agentId !== null) {
            $data['agent_id'] = $agentId;
        }

        return (bool) $this->model->update($id, $data);
    }

    private function hydrate(array $row): Request
    {
        return new Request(
            (int) $row['id'],
            (int) $row['citizen_id'],
            isset($row['service_id']) ? (int) $row['service_id'] : null,
            new RequestType($row['type']),
            $row['description'],
            $row['location'] ?? null,
            new RequestStatus($row['status']),
            isset($row['agent_id']) ? (int) $row['agent_id'] : null,
            $row['created_at'] ?? null,
        );
    }
}
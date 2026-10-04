<?php
namespace App\Modules\Requests\Application;

use App\Modules\Requests\Infrastructure\RequestRepository;

class SubmitRequest
{
    public function execute(int $userId, array $input): int
    {
        return (new RequestRepository())->create([
            'user_id'  => $userId,
            'type'     => 'demande',
            'subject'  => trim($input['subject']),
            'message'  => trim($input['message']),
            'location' => trim($input['location'] ?? ''),
            'status'   => 'nouveau',
        ]);
    }
}
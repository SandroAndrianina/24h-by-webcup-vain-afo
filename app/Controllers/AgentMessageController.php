<?php

namespace App\Controllers;

use App\Models\ContactMessageModel;

class AgentMessageController extends BaseController
{
    public function index()
    {
        $messageModel = new ContactMessageModel();

        $messages = $messageModel
            ->orderBy('created_at', 'DESC')
            ->findAll();

        return view('agent/messages/index', [
            'messages' => $messages,
        ]);
    }

    public function show(int $id)
    {
        $messageModel = new ContactMessageModel();

        $message = $messageModel->find($id);

        if ($message === null) {
            return redirect()
                ->to(site_url('agent/messages'))
                ->with('error', 'Message introuvable.');
        }

        return view('agent/messages/show', [
            'message' => $message,
        ]);
    }
}
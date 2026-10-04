<?php

namespace App\Controllers;

use App\Models\AnnouncementModel;
use App\Models\UserModel;

class AgentAnnouncementController extends BaseController
{
    private function getAgent(): array
    {
        $userModel = new UserModel();

        return $userModel
            ->where('id', session()->get('user_id'))
            ->first();
    }

    public function index()
    {
        $agent = $this->getAgent();

        $announcementModel = new AnnouncementModel();

        $announcements = $announcementModel
            ->where('author_id', $agent['id'])
            ->orderBy('published_at', 'DESC')
            ->findAll();

        return view('agent/announcements/index', [
            'agent' => $agent,
            'announcements' => $announcements,
        ]);
    }

    public function new()
    {
        $agent = $this->getAgent();

        return view('agent/announcements/new', [
            'agent' => $agent,
        ]);
    }

    public function create()
    {
        $agent = $this->getAgent();

        $rules = [
            'title' => 'required|max_length[200]',
            'content' => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Veuillez remplir correctement les champs.');
        }

        $isAlert = $this->request->getPost('is_alert') ? 1 : 0;

        $alertCategory = $this->request->getPost('alert_category');

        if ($isAlert && empty($alertCategory)) {
            $alertCategory = 'Urgence';
        }

        $announcementModel = new AnnouncementModel();

        $announcementModel->insert([
            'title' => $this->request->getPost('title'),
            'content' => $this->request->getPost('content'),
            'is_alert' => $isAlert,
            'published_at' => date('Y-m-d H:i:s'),
            'author_id' => $agent['id'],
            'alert_category' => $alertCategory,
        ]);

        return redirect()
            ->to(site_url('agent/announcements'))
            ->with('success', 'L\'annonce a été publiée.');
    }
}
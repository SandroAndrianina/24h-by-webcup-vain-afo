<?php

namespace App\Libraries;

use App\Models\ContactMessageModel;

class Messages
{
    public const STATUSES = ['nouveau', 'en_cours', 'traite'];

    /** Requête de base : message + nom du citoyen + nom de l'agent assigné */
    public static function base(): ContactMessageModel
    {
        return (new ContactMessageModel())
            ->select('contact_messages.*, c.name AS citizen_name, a.name AS agent_name')
            ->join('users c', 'c.id = contact_messages.user_id', 'left')
            ->join('users a', 'a.id = contact_messages.assigned_agent_id', 'left');
    }

    /** Agent ayant le moins de messages non traités ; en cas d'égalité, l'id le plus petit */
    public static function pickAgentId(): ?int
    {
        $row = db_connect()->query(
            "SELECT u.id
               FROM users u
               JOIN roles r ON r.id = u.role_id AND r.code = 'agent'
               LEFT JOIN contact_messages m
                      ON m.assigned_agent_id = u.id AND m.status <> 'traite' AND m.deleted_at IS NULL
              WHERE u.deleted_at IS NULL
              GROUP BY u.id
              ORDER BY COUNT(m.id) ASC, u.id ASC
              LIMIT 1"
        )->getRowArray();

        return $row ? (int) $row['id'] : null;
    }
}

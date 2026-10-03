<?php

namespace App\Libraries;

/**
 * Transforme les lignes SQL (snake_case) en JSON du contrat (camelCase, dates ISO 8601 UTC).
 */
class Format
{
    public static function iso(?string $dateTime): ?string
    {
        if (! $dateTime) {
            return null;
        }

        return (new \DateTimeImmutable($dateTime, new \DateTimeZone('UTC')))->format('Y-m-d\TH:i:s\Z');
    }

    public static function service(array $r): array
    {
        return [
            'id'               => (int) $r['id'],
            'name'             => $r['name'],
            'shortDescription' => $r['short_description'],
            'details'          => $r['details'] ?? null,
            'icon'             => $r['icon'] ?? null,
            'createdAt'        => self::iso($r['created_at'] ?? null),
            'updatedAt'        => self::iso($r['updated_at'] ?? null),
        ];
    }

    public static function announcement(array $r): array
    {
        return [
            'id'          => (int) $r['id'],
            'title'       => $r['title'],
            'content'     => $r['content'],
            'publishedAt' => self::iso($r['published_at'] ?? null),
            'author'      => ['id' => (int) $r['author_id'], 'name' => $r['author_name'] ?? null],
            'updatedAt'   => self::iso($r['updated_at'] ?? null),
        ];
    }

    public static function message(array $r): array
    {
        $agentId = $r['assigned_agent_id'] ?? null;

        return [
            'id'            => (int) $r['id'],
            'message'       => $r['message'],
            'status'        => $r['status'],
            'citizen'       => ['id' => (int) $r['user_id'], 'name' => $r['citizen_name'] ?? null],
            'assignedAgent' => $agentId ? ['id' => (int) $agentId, 'name' => $r['agent_name'] ?? null] : null,
            'createdAt'     => self::iso($r['created_at'] ?? null),
            'updatedAt'     => self::iso($r['updated_at'] ?? null),
        ];
    }

    public static function novaRequest(array $r): array
    {
        return [
            'requestCode'     => $r['request_code'] ?? null,
            'requesterName'   => $r['requester_name'] ?? null,
            'requesterType'   => $r['requester_type'] ?? null,
            'messagePublic'   => $r['message_public'] ?? null,
            'difficulty'      => $r['difficulty'] ?? null,
            'difficultyLevel' => (int) ($r['difficulty_level'] ?? 0),
            'xpBase'          => (int) ($r['xp_base'] ?? 0),
            'xpTimeBonus'     => (int) ($r['xp_time_bonus'] ?? 0),
            'xpTotal'         => (int) ($r['xp_total'] ?? 0),
            'xpAvailable'     => (int) ($r['xp_available'] ?? 0),
            'groupName'       => $r['group_name'] ?? null,
            'isInitial'       => (bool) ($r['is_initial'] ?? false),
            'waveNumber'      => isset($r['wave_number']) ? (int) $r['wave_number'] : null,
            'arrivalType'     => $r['arrival_type'] ?? null,
            'arrivalTime'     => $r['arrival_time'] ?? null,
        ];
    }

    public static function novaSession(array $s): array
    {
        return [
            'status'               => $s['status'] ?? null,
            'isRunning'            => (bool) ($s['is_running'] ?? false),
            'currentWave'          => (int) ($s['current_wave'] ?? 0),
            'elapsedMinutes'       => (int) ($s['elapsed_minutes'] ?? 0),
            'visibleRequestsCount' => (int) ($s['visible_requests_count'] ?? 0),
            'minutesUntilNextWave' => isset($s['minutes_until_next_wave']) ? (int) $s['minutes_until_next_wave'] : null,
        ];
    }
}

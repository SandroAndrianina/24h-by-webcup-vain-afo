<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run()
    {
        // Table services : id, name, short_description, details, icon, created_at, updated_at, deleted_at
        $rows = [
            [
                'name'              => 'État civil',
                'short_description' => 'Naissances, mariages, décès et documents officiels',
                'details'           => "Horaires : lundi au vendredi, 8h-16h.\nDémarches : déclaration de naissance, acte de mariage, certificat de résidence.\nPièces à fournir : pièce d'identité et justificatif de domicile.\nContact : etatcivil@terranova.test",
                'icon'              => 'file-text',
            ],
            [
                'name'              => 'Santé',
                'short_description' => 'Centres de soins, urgences et prévention',
                'details'           => "Centre médical central ouvert 24h/24.\nVaccinations gratuites chaque mercredi, sans rendez-vous.\nUrgences : ligne 112.\nContact : sante@terranova.test",
                'icon'              => 'heart-pulse',
            ],
            [
                'name'              => 'Urbanisme et logement',
                'short_description' => 'Permis de construire et attribution de logements',
                'details'           => "Dépôt des demandes de permis au guichet ou en ligne.\nDélai moyen d'instruction : 15 jours.\nAttribution de logements : dossier à déposer auprès du service.\nContact : urbanisme@terranova.test",
                'icon'              => 'building-2',
            ],
            [
                'name'              => 'Transports',
                'short_description' => 'Navettes, horaires et lignes de la ville',
                'details'           => "Navettes toutes les 10 minutes en journée (6h-22h).\nLignes : Centre-Dôme, Dôme-Spatioport, Dôme-Serres.\nAbonnement mensuel disponible au guichet.\nContact : transports@terranova.test",
                'icon'              => 'bus',
            ],
            [
                'name'              => 'Environnement et énergie',
                'short_description' => "Eau, énergie, recyclage et qualité de l'air",
                'details'           => "Collecte du recyclage deux fois par semaine.\nSuivi en continu de la qualité de l'air dans les dômes.\nSignalement de fuite ou de panne : environnement@terranova.test",
                'icon'              => 'leaf',
            ],
            [
                'name'              => 'Éducation et jeunesse',
                'short_description' => 'Écoles, activités et soutien aux familles',
                'details'           => "Inscriptions scolaires ouvertes toute l'année.\nActivités jeunesse après l'école.\nAides aux familles : dossier à retirer au service.\nContact : education@terranova.test",
                'icon'              => 'graduation-cap',
            ],
        ];

        $now = date('Y-m-d H:i:s');
        foreach ($rows as &$row) {
            $row['created_at'] = $now;
            $row['updated_at'] = $now;
            $row['deleted_at'] = null;
        }
        unset($row);

        $this->db->table('services')->insertBatch($rows);
    }
}

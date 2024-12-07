<?php

return [
    'dashboard' => [
        'title' => 'Liste',
        'title_add' => 'Ajouter',
        'title_edit' => 'Modification',
        'title_stats' => 'Statistiques',
        'desc' => 'Gestion des redirections',
        'desc_edit' => 'Modification',
        'desc_stats' => 'Statistiques',
        'name' => 'Nom',
        'name_placeholder' => 'Entrez le nom de votre redirection',
        'slug' => 'Slug',
        'slug_placeholder' => 'Entrez le slug ( ex: discord )',
        'slug_hint' => "Le slug est l'url que l'utilisateur verra pour là redirection",
        'target' => 'Cible',
        'target_placeholder' => "Entrez l'url cible ( ex: https://discord.gg/H2eNaZZ98b )",
        'stats_title_click' => 'Nombres de cliques par redirection',
        'stats_number' => 'redirections actives',
        'stats_clicks_total' => 'cliques totaux',
        'stats_clicks_actives' => 'cliques totaux actifs',
        'save_ip' => 'Enregistrer les adresses ip',
        'stats' => [
            'utm' => [
                'title' => 'Redirect - UTM',
                'desc' => 'Statistiques des UTM',
                'heading' => 'Statistiques - UTM',
            ],
        ],
    ],
    'modal' => [
        'delete' => 'Supression de :',
        'deletealert' => 'La supression est definitive.',
    ],
    'list_table' => [
        'id' => 'ID',
        'name' => 'Nom',
        'slug' => 'Slug',
        'target' => 'Cible',
        'click' => 'Cliques',
        'edit' => 'Actions',
    ],
    'toast' => [
        'title_success' => 'Information',
        'title_error' => 'Erreur',
        'create_success' => 'Redirection ajoutée',
        'create_error_name' => 'Nom déjà utilisé',
        'create_error_slug' => 'Slug déjà utilisé',
        'edit_success' => 'Modification effectuée',
        'delete_success' => 'Suppression effectuée',
    ],
    'permissions' => [
        'redirect' => [
            'show' => 'Afficher',
            'create' => 'Créer',
            'edit' => 'Modifier',
            'delete' => 'Supprimer',
            'stats' => 'Afficher les stats',
        ],
    ],
    'menu' => [
        'main' => 'Redirection',
        'manage' => 'Gestion',
        'stats' => [
            'title' => 'Statistiques',
            'general' => 'Générales',
            'utm' => 'UTM',
        ],
    ],
];

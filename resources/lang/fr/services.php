<?php

return [
    'name' => 'Nom',
    'slug' => 'Nom de code',
    'member_list' => 'Utilisateurs',
    'api_key' => 'Clé d\'API',
    'actions' => 'Actions',
    'new' => 'Ajouter un service',

    'create' => [
        'name' => 'Nom du service',
        'slug' => 'Nom de code',
        'slug_error' => 'Votre slug doit être sous la forme [a-z\-]+.',
    ],

    'remove' => [
        'msg' => 'Supprimer',
        'question' => 'Voulez-vous vraiment supprimer ce service ?',
        'confirmation_message' => "Voulez-vous vraiment réinitialiser votre clé d'API ? Vous devrez ensuite reconfigurer vos services ayant un accès externe.\n
        Cette action est irréversible.",
    ],

    'reset' => [
        'api_key' => 'Réinitialiser la clé d\'API',
        'api_key_question' => 'Réinitialiser la clé d\'API ?',
        'api_key_confirmation' => "Voulez-vous vraiment réinitialiser votre clé d'API ? Vous devrez ensuite reconfigurer vos services ayant un accès externe.\n
    Cette action est irréversible.",
        'reset' => 'Réinitialiser',
    ],

    'user' => [
        'add' => 'Ajouter un membre',
        'add_text' => 'Choisissez l\'utilisateur que vous voulez ajouter.',
        'remove' => 'Retirer',
        'remove_member' => 'Retirer un membre',
        'remove_text' => 'Êtes-vous sûr de vouloir retirer cet utilisateur du service ?'
    ]
];

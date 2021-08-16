<?php

use App\Constants\Ability;
use App\Constants\Role;
use App\Constants\Scope;

return [

    Role::ADMIN => [
        'name' => 'Admin',
        'scope' => Scope::SYSTEM,
        'abilities' => [
            Ability::USER_VIEW,
            Ability::USER_CREATE,
            Ability::USER_UPDATE,
            Ability::USER_DELETE,
            Ability::USER_RESTORE,
            Ability::PROJECT_VIEW,
            Ability::PROJECT_CREATE,
        ],
    ],

    Role::DEVELOPER => [
        'name' => 'Developer',
        'scope' => Scope::SYSTEM,
        'abilities' => [
            Ability::USER_VIEW,
            Ability::PROJECT_VIEW,
            Ability::PROJECT_CREATE,
        ],
    ],

    Role::GUEST => [
        'name' => 'Guest',
        'scope' => Scope::SYSTEM,
        'abilities' => [
            Ability::PROJECT_VIEW,
        ],
    ],

    Role::PROJECT_OWNER => [
        'name' => 'Owner',
        'scope' => Scope::PROJECT,
        'abilities' => [
            Ability::PROJECT_UPDATE,
            Ability::PROJECT_DELETE,
            Ability::PROJECT_RESTORE,
            Ability::LANGUAGE_CREATE,
            Ability::LANGUAGE_UPDATE,
            Ability::LANGUAGE_DELETE,
            Ability::KEY_CREATE,
            Ability::KEY_UPDATE,
            Ability::KEY_DELETE,
            Ability::VALUE_CREATE,
            Ability::VALUE_UPDATE,
            Ability::VALUE_DELETE,
        ],
    ],

    Role::PROJECT_MAINTAINER => [
        'name' => 'Maintainer',
        'scope' => Scope::PROJECT,
        'abilities' => [
            Ability::PROJECT_UPDATE,
            Ability::LANGUAGE_UPDATE,
            Ability::KEY_CREATE,
            Ability::KEY_UPDATE,
            Ability::KEY_DELETE,
            Ability::VALUE_CREATE,
            Ability::VALUE_UPDATE,
            Ability::VALUE_DELETE,
        ],
    ],

    Role::PROJECT_GUEST => [
        'name' => 'Guest',
        'scope' => Scope::PROJECT,
        'abilities' => [
            //
        ],
    ],

];

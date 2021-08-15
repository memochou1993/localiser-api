<?php

use App\Enums\Role;

return [

    Role::SYSTEM_ADMIN => [

        'name' => 'Admin',
        'abilities' => [
            'view-users',
            'create-users',
            'update-users',
            'delete-users',
            'restore-users',
        ],

    ],

    Role::SYSTEM_USER => [

        'name' => 'User',
        'abilities' => [
            'view-users',
        ],

    ],

    Role::PROJECT_OWNER => [
        'view-projects',
        'create-projects',
        'update-projects',
        'delete-projects',
        'restore-projects',
        'view-keys',
        'create-keys',
        'update-keys',
        'delete-keys',
        'view-values',
        'create-values',
        'update-values',
        'delete-values',
    ],

    Role::PROJECT_MAINTAINER => [
        'view-projects',
        'create-projects',
        'update-projects',
        'view-keys',
        'create-keys',
        'update-keys',
        'view-values',
        'create-values',
        'update-values',
    ],

    Role::PROJECT_REVIEWER => [
        'view-projects',
        'view-keys',
        'view-values',
    ],

];

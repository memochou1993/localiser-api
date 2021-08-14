<?php

return [

    'admin' => [
        'view-users',
        'create-users',
        'update-users',
        'delete-users',
        'restore-users',
    ],

    'user' => [
        'view-users',
    ],

    'owner' => [
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

    'maintainer' => [
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

    'reviewer' => [
        'view-projects',
        'view-keys',
        'view-values',
    ],

];

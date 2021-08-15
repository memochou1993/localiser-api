<?php

namespace App\Enums;

class Role {
    const SYSTEM_ADMIN = 1;
    const SYSTEM_USER = 2;
    const PROJECT_OWNER = 11;
    const PROJECT_MAINTAINER = 12;
    const PROJECT_REVIEWER = 13;
}

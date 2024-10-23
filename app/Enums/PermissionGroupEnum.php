<?php

namespace App\Enums;

enum PermissionGroupEnum: string
{
    case DASHBOARD = 'dashboard';

    case User = 'user';

    case ROLE = 'role';

    case PERMISSION = 'permission';

    case ROLE_HAS_PERMISSION = 'rolehaspermission';
}


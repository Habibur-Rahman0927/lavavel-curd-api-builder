<?php

namespace App\Enums;

enum PermissionEnum: string
{
    case ADMIN_DASHBOARD = 'admin-dashboard';

    case USER_INDEX = 'user.index';
    case USER_CREATE = 'user.create';
    case USER_EDIT = 'user.edit';

    case ROLE_INDEX = 'role.index';
    case ROLE_CREATE = 'role.create';
    case ROLE_EDIT = 'role.edit';

    case PERMISSION_INDEX = 'permission.index';
    case PERMISSION_CREATE = 'permission.create';
    case PERMISSION_EDIT = 'permission.edit';

    case ROLE_HAS_PERMISSION_INDEX = 'rolehaspermission.index';
    case ROLE_HAS_PERMISSION_CREATE = 'rolehaspermission.create';
    case ROLE_HAS_PERMISSION_EDIT = 'rolehaspermission.edit';
}
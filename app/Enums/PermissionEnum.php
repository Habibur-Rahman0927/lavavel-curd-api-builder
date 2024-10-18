<?php

namespace App\Enums;

enum PermissionEnum: string
{
    case ADMIN_DASHBOARD = 'admin-dashboard';

    case USER_INDEX = 'user.index';
    case USER_CREATE = 'user.create';
    case USER_EDIT = 'user.edit';
}
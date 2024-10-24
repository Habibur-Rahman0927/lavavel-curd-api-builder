<?php

namespace App\Enums;

enum PermissionEnum: string
{
    case ADMIN_DASHBOARD = 'admin-dashboard';

    case USER_INDEX = 'user.index';
    case USER_LIST = 'user-list';
    case USER_CREATE = 'user.create';
    case USER_STORE = 'user.store';
    case USER_EDIT = 'user.edit';
    case USER_UPDATE = 'user.update';
    case USER_DESTROY = 'user.destroy';

    case CURD_GENERATOR_CREATE = 'crud.generator.create';
    case CURD_GENERATOR_STORE = 'crud.generator.store';

    case ROLE_INDEX = 'role.index';
    case ROLE_CREATE = 'role.create';
    case ROLE_EDIT = 'role.edit';

    case PERMISSION_GROUP_INDEX = 'permissiongroup.index';
    case PERMISSION_GROUP_LIST = 'permissiongroup-list';
    case PERMISSION_GROUP_CREATE = 'permissiongroup.create';
    case PERMISSION_GROUP_STORE = 'permissiongroup.store';
    case PERMISSION_GROUP_EDIT = 'permissiongroup.edit';
    case PERMISSION_GROUP_UPDATE = 'permissiongroup.update';
    case PERMISSION_GROUP_DESTROY = 'permissiongroup.destroy';

    case PERMISSION_INDEX = 'permission.index';
    case PERMISSION_CREATE = 'permission.create';
    case PERMISSION_EDIT = 'permission.edit';

    case ROLE_HAS_PERMISSION_INDEX = 'rolehaspermission.index';
    case ROLE_HAS_PERMISSION_CREATE = 'rolehaspermission.create';
    case ROLE_HAS_PERMISSION_EDIT = 'rolehaspermission.edit';
}
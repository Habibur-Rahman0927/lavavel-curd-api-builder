<?php 
 
 
namespace App\Services;

use App\Repositories\User\IUserRepository;


class UserService extends BaseService implements IUserService
{
    public function __construct(private IUserRepository $userRepository)
    {
        parent::__construct($userRepository);
    }
}

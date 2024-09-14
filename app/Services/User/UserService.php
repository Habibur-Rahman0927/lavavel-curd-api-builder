<?php 


namespace App\Services\User;

use App\Repositories\User\IUserRepository;
use App\Services\BaseService;

class UserService extends BaseService implements IUserService
{
    public function __construct(private IUserRepository $userRepository)
    {
        parent::__construct($userRepository);
    }
}

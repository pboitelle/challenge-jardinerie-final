<?php 

namespace App\Controller;

use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class MeController
{
    public function __construct(private Security $security)
    {
    }

    public function __invoke()
    {
        $user = $this->security->getUser();

        return $user;
    }
}
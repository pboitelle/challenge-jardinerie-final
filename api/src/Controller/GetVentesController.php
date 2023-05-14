<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[AsController]
class GetVentesController extends AbstractController
{
    public function __construct(
        private ManagerRegistry $managerRegistry,
        private Security $security
    ) {}


    public function __invoke(string $id)
    {
        $em = $this->managerRegistry->getManager();
        
        /** @var User $user */
        if (!$user = $em->getRepository(User::class)->findOneBy(['id' => $id])) {
            throw new NotFoundHttpException();
        }

        $userAuth = $this->security->getUser();

        if (!$userAuth) {
            throw new AccessDeniedHttpException('User not authenticated');
        }

        if ($user === $userAuth){
            return $user->getVentes();
        }

        return [];
    }
}
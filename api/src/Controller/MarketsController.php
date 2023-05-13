<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Market;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[AsController]
class MarketsController extends AbstractController
{
    public function __construct(
        private ManagerRegistry $managerRegistry,
        private Security $security
    ) {}


    public function __invoke()
    {
        $em = $this->managerRegistry->getManager();

        $userAuth = $this->security->getUser();

        if (!$userAuth) {
            throw new AccessDeniedHttpException('User not authenticated');
        }

        $markets = $em->getRepository(Market::class)->createQueryBuilder('m')
            ->where('m.user_id != :user')
            ->setParameter('user', $userAuth)
            ->getQuery()
            ->getResult();

        return $markets;
    }
}
<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\JsonResponse;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[AsController]
class UpdateDebitCoinsController extends AbstractController
{
    public function __construct(
        private RequestStack $requestStack,
        private ManagerRegistry $managerRegistry
    ) {}


    public function __invoke(string $id): User
    {
        $request = $this->requestStack->getCurrentRequest();

        $nb_coins = json_decode($request->getContent())->nbCoins;

        $em = $this->managerRegistry->getManager();
        
        /** @var User $user */
        if (!$user = $em->getRepository(User::class)->findOneBy(['id' => $id])) {
            throw new NotFoundHttpException();
        }

        $user->setNbCoins($user->getNbCoins() + $nb_coins);
        $em->flush();

        return $user;
    }
}
<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Item;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Component\Security\Core\Security;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[AsController]
class ItemChangeUserController extends AbstractController
{
    public function __construct(
        private RequestStack $requestStack,
        private ManagerRegistry $managerRegistry,
        private Security $security
    ) {}


    public function __invoke(string $id)
    {
        $request = $this->requestStack->getCurrentRequest();

        $userId = json_decode($request->getContent())->userId;

        $userAuth = $this->security->getUser();

        if (!$userAuth) {
            throw new AccessDeniedHttpException('User not authenticated');
        }

        $em = $this->managerRegistry->getManager();
        if (!$user = $em->getRepository(User::class)->findOneBy(['id' => $userId])) {
            throw new NotFoundHttpException('User not found');
        }

        $em = $this->managerRegistry->getManager();
        if (!$item = $em->getRepository(Item::class)->findOneBy(['id' => $id])) {
            throw new NotFoundHttpException('Item not found');
        }

        $item->setUserId($user);
        $em->flush();

        return new JsonResponse([
            'code' => 200,
            'status' => 'Item updated!'
        ]);
    }
}
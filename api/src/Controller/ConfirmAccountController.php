<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;


#[AsController]
class ConfirmAccountController extends AbstractController
{
    public function __construct(
        private RequestStack $requestStack,
        private ManagerRegistry $managerRegistry
    ) {}

    public function __invoke()
    {
        $request = $this->requestStack->getCurrentRequest();

        $token_account = json_decode($request->getContent())->token_account;

        $em = $this->managerRegistry->getManager();
        /** @var User $user */
        if (!$user = $em->getRepository(User::class)->findOneBy(['token_account' => $token_account])) {
            return new Response('Le lien de confirmation de compte a expiré, veuillez quitter cette page !', Response::HTTP_BAD_REQUEST);
        }

        $user->setTokenAccount(null);

        $em->flush();

        return new JSONResponse('Votre compte a bien été confirmé !', Response::HTTP_OK);
    }
}

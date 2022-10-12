<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class ResetPasswordController extends AbstractController
{
    public function __construct(
        private RequestStack $requestStack,
        private ManagerRegistry $managerRegistry
    ) {}

    public function __invoke()
    {
        $request = $this->requestStack->getCurrentRequest();
        // TODO: test email
        $email = json_decode($request->getContent())->email;

        $em = $this->managerRegistry->getManager();
        /** @var User $user */
        if (!$user = $em->getRepository(User::class)->findOneBy(['email' => $email])) {
            return $this->createNotFoundException();
        }

        $user->setToken(bin2hex(random_bytes(32)));
        $em->flush();

        // TODO: send Email

        return $this->json($email);
    }
}

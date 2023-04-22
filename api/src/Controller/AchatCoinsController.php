<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Mime\Email;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\HttpFoundation\Response;


#[AsController]
class AchatCoinsController extends AbstractController
{
    public function __construct(
        private RequestStack $requestStack,
        private ManagerRegistry $managerRegistry,
        private MailerInterface $mailer,
        private UserPasswordHasherInterface $passwordEncoder
    ) {}

    public function __invoke(string $id)
    {
        $request = $this->requestStack->getCurrentRequest();

        $nb_coins = json_decode($request->getContent())->coins;

        $em = $this->managerRegistry->getManager();
        /** @var User $user */
        if (!$user = $em->getRepository(User::class)->findOneBy(['id' => $id])) {
            return new Response('User not found', Response::HTTP_NOT_FOUND);
        }

        $user->setNbCoins($user->getNbCoins() + $nb_coins);

        $em->flush();

        // TODO: send Email
        $message = (new TemplatedEmail())
            ->from('jardinerie.challenge@gmail.com')
            ->to($user->getEmail())
            ->subject('Réinitialisation de votre mot de passe')

            ->htmlTemplate('change_password.html.twig')

            ->context([
                'user' => $user,
            ]);

        $this->mailer->send($message);


        return new Response('Password changed', Response::HTTP_OK);
    }
}

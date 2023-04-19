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
class ChangePasswordController extends AbstractController
{
    public function __construct(
        private RequestStack $requestStack,
        private ManagerRegistry $managerRegistry,
        private MailerInterface $mailer,
        private UserPasswordHasherInterface $passwordEncoder
    ) {}

    public function __invoke()
    {
        $request = $this->requestStack->getCurrentRequest();

        $password = json_decode($request->getContent())->password;
        $token = json_decode($request->getContent())->token;

        $em = $this->managerRegistry->getManager();
        /** @var User $user */
        if (!$user = $em->getRepository(User::class)->findOneBy(['token' => $token])) {
            return new Response('Le lien de réinitialisation de mot de passe a expiré, veuillez quitter cette page !', Response::HTTP_BAD_REQUEST);
        }

        // Update the user's password
        $password_hashed = $this->passwordEncoder->hashPassword($user, $password);
        $user->setPassword($password_hashed);
        $user->setToken(null);

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

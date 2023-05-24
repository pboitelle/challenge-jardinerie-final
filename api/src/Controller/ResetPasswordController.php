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


#[AsController]
class ResetPasswordController extends AbstractController
{
    public function __construct(
        private RequestStack $requestStack,
        private ManagerRegistry $managerRegistry,
        private MailerInterface $mailer
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

        
        $message = (new TemplatedEmail())
            ->from('jardinerie.challenge@gmail.com')
            ->to($email)
            ->subject('Réinitialisation de votre mot de passe')

            ->htmlTemplate('reset_password.html.twig')

            ->context([
                'user' => $user,
            ]);

        $this->mailer->send($message);


        return $this->json($email);
    }
}

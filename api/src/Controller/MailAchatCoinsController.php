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
use Symfony\Component\HttpFoundation\Response;


#[AsController]
class MailAchatCoinsController extends AbstractController
{
    public function __construct(
        private RequestStack $requestStack,
        private ManagerRegistry $managerRegistry,
        private MailerInterface $mailer
    ) {}

    public function __invoke(string $id, string $coins): Response
    {
        $request = $this->requestStack->getCurrentRequest();


        $em = $this->managerRegistry->getManager();
        /** @var User $user */
        if (!$user = $em->getRepository(User::class)->findOneBy(['id' => $id])) {
            return new Response('User not found', Response::HTTP_NOT_FOUND);
        }

        $user->setNbCoins($user->getNbCoins() + $coins);
        $em->persist($user);
        $em->flush();


        // TODO: send Email
        $message = (new TemplatedEmail())
            ->from('jardinerie.challenge@gmail.com')
            ->to($user->getEmail())
            ->subject('Jardinerie Online | Achat de coins')

            ->htmlTemplate('achat_coins.html.twig')

            ->context([
                'user' => $user,
                'nb_coins' => $coins,
            ]);

        $this->mailer->send($message);


        return new Response('Mail envoyé', Response::HTTP_OK);
    }
}

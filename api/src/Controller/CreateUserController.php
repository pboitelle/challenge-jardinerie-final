<?php 

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Mime\Email;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Entity\User;

#[AsController]
class CreateUserController extends AbstractController
{
    public function __construct(
        private RequestStack $requestStack, 
        private ManagerRegistry $managerRegistry,
        private MailerInterface $mailer,
        private UserPasswordHasherInterface $passwordEncoder
    ){}

    public function __invoke()
    {
        $request = $this->requestStack->getCurrentRequest();

        $firstname = json_decode($request->getContent())->firstname;
        $lastname = json_decode($request->getContent())->lastname;
        $email = json_decode($request->getContent())->email;
        $password = json_decode($request->getContent())->password;

        $em = $this->managerRegistry->getManager();

        $user = new User();
        $user->setFirstname($firstname);
        $user->setLastname($lastname);
        $user->setEmail($email);
        $password_hashed = $this->passwordEncoder->hashPassword($user, $password);
        $user->setPassword($password_hashed);
        $user->setRoles(['ROLE_USER']);
        $user->setNbCoins(50);
        $user->setTokenAccount(bin2hex(random_bytes(32)));

        $em->persist($user);
        $em->flush();


        $message = (new TemplatedEmail())
            ->from('jardinerie.challenge@gmail.com')
            ->to($email)
            ->subject('Confirmation de votre compte')
            ->htmlTemplate('confirmation_account.html.twig')
            ->context([
                'user' => $user,
            ]);

        $this->mailer->send($message);

        return new JsonResponse([
            'status' => 201,
            'message' => 'Votre compte a bien été créé. Vous allez recevoir un email de confirmation.'
        ]);
    }
}
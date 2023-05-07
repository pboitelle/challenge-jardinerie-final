<?php 

namespace App\Controller;

use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\DemandeBlogger;

#[AsController]
class CreateDemandeBloggerController
{
    public function __construct(
        private Security $security, 
        private RequestStack $requestStack, 
        private ManagerRegistry $managerRegistry
    ){}

    public function __invoke()
    {
        $request = $this->requestStack->getCurrentRequest();

        $motif = json_decode($request->getContent())->motif;

        $user = $this->security->getUser();

        if (!$user) {
            throw new AccessDeniedHttpException('User not authenticated');
        }

        //chercher la dernière entrée de l'utilisateur
        $last_demande = $this->managerRegistry->getRepository(DemandeBlogger::class)->findOneBy(['user_id' => $user], ['created_at' => 'DESC']);
        if($last_demande){
            $last_demande_date = $last_demande->getCreatedAt();
            $now = new \DateTimeImmutable();
            $interval = $now->diff($last_demande_date);

            if($interval->days < 3){
                return new JsonResponse(['message' => 'Vous avez déjà fait une demande pour devenir blogger il y a moins de 3 jours. Votre demande est en cours d\'analyse par un administrateur.'], 400);
            }
        }

        $em = $this->managerRegistry->getManager();

        $demande = new DemandeBlogger();
        $demande->setMotif($motif);
        $demande->setCreatedAt(new \DateTimeImmutable());
        $demande->setUserId($user);

        return $demande;
    }
}
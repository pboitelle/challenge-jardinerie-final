<?php 

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\User;
use App\Entity\Item;
use App\Entity\Vente;

#[AsController]
class CreateVenteController extends AbstractController
{
    public function __construct(
        private Security $security, 
        private RequestStack $requestStack, 
        private ManagerRegistry $managerRegistry
    ){}

    public function __invoke()
    {
        $request = $this->requestStack->getCurrentRequest();

        $vendeurId = json_decode($request->getContent())->vendeurId;
        $prix = json_decode($request->getContent())->prix;
        $itemId = json_decode($request->getContent())->item;

        $user = $this->security->getUser();

        if (!$user) {
            throw new AccessDeniedHttpException('User not authenticated');
        }

        //chercher si l'item existe
        $item = $this->managerRegistry->getRepository(Item::class)->find($itemId->id);

        if (!$item) {
            throw new AccessDeniedHttpException('Item not found');
        }

        //chercher si le vendeur existe
        $vendeur = $this->managerRegistry->getRepository(User::class)->findOneBy(['id' => $vendeurId]);

        if (!$vendeur) {
            throw new AccessDeniedHttpException('User not found');
        }

        $em = $this->managerRegistry->getManager();

        $vente = new Vente();
        $vente->setVendeur($vendeur);
        $vente->setAcheteur($user);
        $vente->setItem($item);
        $vente->setPrix($prix);

        $em->persist($vente);
        $em->flush();

        return new JsonResponse([
            'status' => 201,
            'message' => 'Vente créée'
        ]);
    }
}
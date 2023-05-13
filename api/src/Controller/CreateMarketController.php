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
use App\Entity\Market;

#[AsController]
class CreateMarketController extends AbstractController
{
    public function __construct(
        private Security $security, 
        private RequestStack $requestStack, 
        private ManagerRegistry $managerRegistry
    ){}

    public function __invoke()
    {
        $request = $this->requestStack->getCurrentRequest();

        $item_id = json_decode($request->getContent())->item_id;
        $prix = json_decode($request->getContent())->prix;

        $user = $this->security->getUser();

        if (!$user) {
            throw new AccessDeniedHttpException('User not authenticated');
        }

        //chercher si la plante existe
        $item = $this->managerRegistry->getRepository(Item::class)->findOneBy(['id' => $item_id]);

        if (!$item) {
            throw new AccessDeniedHttpException('Item not found');
        }

        //chercher si l'item existe sur le marché
        $market = $this->managerRegistry->getRepository(Market::class)->findOneBy(['item_id' => $item]);

        if ($market) {
            throw new AccessDeniedHttpException('Item already on market');
        }

        $em = $this->managerRegistry->getManager();

        $market = new Market();
        $market->setItemId($item);
        $market->setUserId($user);
        $market->setPrix($prix);

        $em->persist($market);
        $em->flush();

        return new JsonResponse([
            'status' => 201,
            'message' => 'Item added to market'
        ]);
    }
}
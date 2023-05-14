<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[AsController]
class GetItemsController extends AbstractController
{
    public function __construct(
        private ManagerRegistry $managerRegistry,
        private Security $security
    ) {}


    public function __invoke(string $id)
    {
        $em = $this->managerRegistry->getManager();
        
        /** @var User $user */
        if (!$user = $em->getRepository(User::class)->findOneBy(['id' => $id])) {
            throw new NotFoundHttpException();
        }

        $userAuth = $this->security->getUser();

        if (!$userAuth) {
            throw new AccessDeniedHttpException('User not authenticated');
        }

        if ($user === $userAuth){
            // $items dont les items ont getMarket() == null (pas dans le marché
            $items = $user->getItems()->filter(function($item) {
                return $item->getMarket() == null;
            });

            //trier les items par nom decroissant
            $items = $items->toArray();
            usort($items, function($a, $b) {
                if ($a->getNiveau() == $b->getNiveau()) {
                    return $b->getPlante() <=> $a->getPlante(); // si les niveaux sont égaux, trier par ordre décroissant de plante
                }
                return $b->getNiveau() <=> $a->getNiveau(); // trier par ordre décroissant de niveau
            });
            return $items;
        }

        return [];
    }
}
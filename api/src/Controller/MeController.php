<?php 

namespace App\Controller;

use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Serializer\Filter\PropertyFilter;
use Symfony\Component\HttpFoundation\JsonResponse;

#[ApiFilter(PropertyFilter::class)]
#[ApiFilter(SearchFilter::class)]
#[AsController]
class MeController
{
    public function __construct(private Security $security)
    {
    }

    public function __invoke()
    {
        $user = $this->security->getUser();

        if (!$user) {
            throw new AccessDeniedHttpException('User not authenticated');
        }

        return $user;
    }
}
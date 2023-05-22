<?php

namespace App\Controller;

use App\Entity\Blog;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[AsController]
class GetValidateBlogsController extends AbstractController
{
    public function __construct(
        private ManagerRegistry $managerRegistry
    ) {}


    public function __invoke()
    {
        $em = $this->managerRegistry->getManager();
        
        /** @var Blog $blog */
        if (!$blogs = $em->getRepository(Blog::class)->findBy(['isValidate' => true])) {
            return [];
        }


        return $blogs;
    }
}
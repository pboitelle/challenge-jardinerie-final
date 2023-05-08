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
use App\Entity\Blog;
use App\Entity\Plante;


#[AsController]
class CreateBlogController extends AbstractController
{
    public function __construct(
        private Security $security, 
        private RequestStack $requestStack, 
        private ManagerRegistry $managerRegistry
    ){}

    public function __invoke()
    {
        $request = $this->requestStack->getCurrentRequest();

        $plante_id = json_decode($request->getContent())->planteId;
        $title = json_decode($request->getContent())->title;
        $description = json_decode($request->getContent())->description;
        $area = json_decode($request->getContent())->area;

        $user = $this->security->getUser();

        if (!$user) {
            throw new AccessDeniedHttpException('User not authenticated');
        }

        //chercher si la plante existe
        $plante = $this->managerRegistry->getRepository(Plante::class)->findOneBy(['id' => $plante_id]);

        if (!$plante) {
            throw new AccessDeniedHttpException('Plante not exist');
        }

        //chercher si la plante a déja un blog
        $blog = $this->managerRegistry->getRepository(Blog::class)->findOneBy(['plante' => $plante]);

        if ($blog) {
            throw new AccessDeniedHttpException('Blog already exist');
        }

        $em = $this->managerRegistry->getManager();

        $blog = new Blog();
        $blog->setPlante($plante);
        $blog->setTitle($title);
        $blog->setDescription($description);
        $blog->setArea($area);
        $blog->setUserId($user);
        $blog->setIsValidate(false);
        $blog->setCreatedAt(new \DateTimeImmutable());
        $blog->setUpdateAt(new \DateTimeImmutable());

        $em->persist($blog);
        $em->flush();

        return $blog;
    }
}
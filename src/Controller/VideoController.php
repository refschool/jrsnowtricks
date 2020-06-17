<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/videos")
 * @IsGranted("ROLE_USER")
 */
class VideoController extends AbstractController
{
    /** @Route("/add", name="videos_add") */
    public function videoAdd()
    {
        return $this->json('ok');
    }

    /** @Route("/{id}/remove", name="videos_remove") */
    public function videoRemove(string $id): Response
    {
        return $this->json('ok on cherche à supprimer la '. $id);
    }
}

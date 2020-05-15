<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/videos")
 */
class VideoController extends AbstractController
{
    /**
     * @Route("/{id}/remove", name="videos_remove")
     */
    public function videoRemove(string $id): Response
    {
        return $this->json('ok on cherche à supprimer la '. $id);
    }
}

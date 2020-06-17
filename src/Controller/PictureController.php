<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/pictures")
 * @IsGranted("ROLE_USER")
 */
class PictureController extends AbstractController
{
    /** @Route("/add", name="pictures_add") */
    public function pictureAdd()
    {
        return $this->json('ok');
    }

    /** @Route("/{id}/remove", name="pictures_remove") */
    public function pictureRemove()
    {
        return $this->json('ok');
    }
}

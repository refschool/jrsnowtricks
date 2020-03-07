<?php

namespace App\Controller;

use App\Entity\Figure;
use App\Form\FigureType;
use App\Repository\FigureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/")
 */
class FigureController extends AbstractController
{
    /**
     * @Route("/", name="figure_index", methods={"GET"})
     */
    public function index(FigureRepository $figureRepository): Response
    {
        return $this->render('figure/index.html.twig', [
            'figures' => $figureRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="figure_new", methods={"GET","POST"})
     */
    public function new(Request $request, string $photoDir): Response
    {
        $figure = new Figure();
        $form = $this->createForm(FigureType::class, $figure);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($photo = $form['pictures']->getData()) {
                $filename = bin2hex(random_bytes(6)) . '.' . $photo->guessExtension();
                dump($filename);
                try {
                    $photo->move($photoDir, $filename);
                } catch (FileException $e) {
                    //Upload failed
                }
                $figure->addPicture($filename);
            }

            if ($link = $form['videos']->getData()) {
                $figure->addVideo($link);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($figure);
            $entityManager->flush();

            return $this->redirectToRoute('figure_index');
        }

        return $this->render('figure/new.html.twig', [
            'figure' => $figure,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{slug}", name="figure_show", methods={"GET"})
     */
    public function show(Figure $figure): Response
    {
        return $this->render('figure/show.html.twig', [
            'figure' => $figure,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="figure_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Figure $figure, string $photoDir): Response
    {
        $form = $this->createForm(FigureType::class, $figure);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($photo = $form['pictures']->getData()) {
                $filename= bin2hex(random_bytes(6)).'.'.$photo->guessExtension();
                $photo->move($photoDir, $filename);
                $figure->addPicture($filename);
            }

            if ($link = $form['videos']->getData()) {
                $figure->addVideo($link);
            }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('figure_index');
        }

        return $this->render('figure/edit.html.twig', [
            'figure' => $figure,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="figure_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Figure $figure): Response
    {
        if ($this->isCsrfTokenValid('delete'.$figure->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($figure);
            $entityManager->flush();
        }

        return $this->redirectToRoute('figure_index');
    }
}

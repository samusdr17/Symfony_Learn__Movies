<?php

namespace App\Controller;

use App\Entity\Pelicula;
use App\Form\PeliculaFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



class MainController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index()
    {
        return $this->render(
            'base.html.twig',
            [
                'name' => 'SAMU'
            ]
        );
    }
    /**
     * @Route("/peliculas", name="listar peliculas")
     */
    public function listarPeliculas(EntityManagerInterface $em)
    {
        $repositorio = $em->getRepository(Pelicula::class);
        $peliculas = $repositorio->findAll();
        return $this -> render(
            'peliculas/list.html.twig',
            [
                'movies' => $peliculas
            ]
        );
    }

    /**
     * @Route("/peliculas/nueva", name="nueva pelicula")
     */
    public function nuevaPelicula(Request $request, EntityManagerInterface $em)
    {

        $form = $this->createForm(PeliculaFormType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $pelicula = $form->getData();


            $em->persist($pelicula);
            $em->flush();

            return $this->redirectToRoute('listar peliculas');
        }


        return $this->render(
            'peliculas/nueva.html.twig',
            [
                'formulario' => $form->createView()
            ]
        );
    }


    /**
     * @Route("/peliculas/edit/{id}", name="editar pelicula")
     */
    public function editarPelicula(Pelicula $pelicula, Request $request, EntityManagerInterface $em)
    {
        // dd($pelicula);

        $form = $this->createForm(PeliculaFormType::class, $pelicula);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $pelicula = $form->getData();


            $em->persist($pelicula);
            $em->flush();

            return $this->redirectToRoute('listar peliculas');
        }


        return $this->render(
            'peliculas/nueva.html.twig',
            [
                'formulario' => $form->createView()
            ]
        );
    }
}
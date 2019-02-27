<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class IncidenciaController extends AbstractController
{
    /**
     * @Route("/incidencia", name="incidencia")
     */
    public function index()
    {
        return $this->render('incidencia/index.html.twig');
    }
}

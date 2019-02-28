<?php

namespace App\Controller;

use App\Entity\Categoria;
use App\Entity\Incidencia;
use App\Entity\Prioridad;
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

    /**
     * @Route("/busqueda", name="busqueda")
     */
    public function busqueda(){

        if (isset($_POST['buscarIncidencia'])) {

            $incidencia = new Incidencia($this->getDoctrine());
            $incidencias = $incidencia->getLike($_POST['descripcionIncidencia']);

            $prioridad = new Prioridad($this->getDoctrine());
            $prioridades = $prioridad->getAll();

            $categoria = new Categoria($this->getDoctrine());
            $categorias = $categoria->getAll();

            return $this->render('index/index.html.twig', [
                'incidencias' => $incidencias,
                'prioridades' => $prioridades,
                'categorias' => $categorias
            ]);
        }
        else {

            $incidencia = new Incidencia($this->getDoctrine());
            $incidencias = $incidencia->getAll();

            $prioridad = new Prioridad($this->getDoctrine());
            $prioridades = $prioridad->getAll();

            $categoria = new Categoria($this->getDoctrine());
            $categorias = $categoria->getAll();

            return $this->render('index/index.html.twig', [
                'incidencias' => $incidencias,
                'prioridades' => $prioridades,
                'categorias' => $categorias
            ]);
        }

    }
}

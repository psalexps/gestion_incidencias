<?php

namespace App\Controller;

use App\Entity\Incidencia;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class EstadisticasController extends AbstractController{

    /**
     * @Route("/cargarEstadisticas", name="cargarEstadisticas")
     */
    public function cargarEstadisticas(){

        return $this->render('index/estadisticas.html.twig', [
            'tipo' => $_SESSION['tipo']
        ]);
    }

    /**
     * @Route("/cargarEstadisticasIncidenciasAbiertas", name="cargarEstadisticasIncidenciasAbiertas")
     */
    public function cargarEstadisticasIncidenciasAbiertas(){

        $incidencia = new Incidencia($this->getDoctrine());
        $incidenciasAbiertas = $incidencia->getAllAbiertasCategoria();

        return new JsonResponse($incidenciasAbiertas);

    }

    /**
     * @Route("/cargarEstadisticasIncidenciasCerradas", name="cargarEstadisticasIncidenciasCerradas")
     */
    public function cargarEstadisticasIncidenciasCerradas(){

        $incidencia = new Incidencia($this->getDoctrine());
        $incidenciasCerradas = $incidencia->getAllCerradasCategoria();

        return new JsonResponse($incidenciasCerradas);

    }

    /**
     * @Route("/cargarEstadisticasIncidenciasCerradasTecnicos", name="cargarEstadisticasIncidenciasCerradasTecnicos")
     */
    public function cargarEstadisticasIncidenciasCerradasTecnicos(){

        $incidencia = new Incidencia($this->getDoctrine());
        $incidenciasCerradasTecnicos = $incidencia->getAllCerradasTecnicos();

        return new JsonResponse($incidenciasCerradasTecnicos);

    }

}
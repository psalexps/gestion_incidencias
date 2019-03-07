<?php

namespace App\Controller;

use App\Entity\Anotacion;
use App\Entity\Categoria;
use App\Entity\Cliente;
use App\Entity\Incidencia;
use App\Entity\Prioridad;
use App\Entity\Usuario;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AnotacionController extends AbstractController{

    /**
     * @Route("/nuevaAnotacion", name="nuevaAnotacion")
     */
    public function nuevaAnotacion(){


        $anotacion = new Anotacion($this->getDoctrine());
        $anotacion->setTecnico($_SESSION['idUsuario']);
        $anotacion->setFechaHora(date('Y/m/d g:i:s'));
        $anotacion->setDescripcion($_POST['anotacion']);
        $anotacion->setIncidencia($_GET['ii']);
        $anotacion->insert();

        $anotaciones = $anotacion->getAllIdIncidencia();

        $incidencia = new Incidencia($this->getDoctrine());
        $incidencia->setId($_GET['ii']);
        $incidencias = $incidencia->getSelectId();

        $cliente = new Cliente($this->getDoctrine());
        $cliente->setId($incidencias[0]['cliente']);
        $clientes = $cliente->getSelectId();

        $prioridad = new Prioridad($this->getDoctrine());
        $prioridades = $prioridad->getAll();

        $categoria = new Categoria($this->getDoctrine());
        $categorias = $categoria->getAll();

        $tecnico = new Usuario($this->getDoctrine());
        $tecnicos = $tecnico->getAll();

        return $this->render('incidencia/detallesIncidencia.html.twig', [
            'incidencias' => $incidencias,
            'prioridades' => $prioridades,
            'categorias' => $categorias,
            'tecnicos' => $tecnicos,
            'tipo' => $_SESSION['tipo'],
            'anotaciones' => !empty($anotaciones) ? $anotaciones : '',
            'clientes' => !empty($clientes) ? $clientes : ''
        ]);

    }

}

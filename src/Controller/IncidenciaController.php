<?php

namespace App\Controller;

use App\Entity\Categoria;
use App\Entity\Incidencia;
use App\Entity\Prioridad;
use App\Entity\Usuario;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class IncidenciaController extends AbstractController{

    private function ipc($view,$get,$post){

        if ($post == ''){

            $incidencia = new Incidencia($this->getDoctrine());
            $incidencias = $incidencia->$get();
        }
        else {

            $incidencia = new Incidencia($this->getDoctrine());
            $incidencias = $incidencia->$get($_POST[$post]);
        }

        $prioridad = new Prioridad($this->getDoctrine());
        $prioridades = $prioridad->getAll();

        $categoria = new Categoria($this->getDoctrine());
        $categorias = $categoria->getAll();

        $tecnico = new Usuario($this->getDoctrine());
        $tecnicos = $tecnico->getAll();

        return $this->render($view, [
            'incidencias' => $incidencias,
            'prioridades' => $prioridades,
            'categorias' => $categorias,
            'tecnicos' => $tecnicos,
            'tipo' => $_SESSION['tipo']
        ]);
    }

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

            if (empty($_POST['fechaIncidencia']) && empty($_POST['prioridadIncidencia']) && empty($_POST['categoriaIncidencia'])){

                return $this->ipc('index/index.html.twig','getDesc','descripcionIncidencia');
            }
            elseif (empty($_POST['descripcionIncidencia']) && empty($_POST['prioridadIncidencia']) && empty($_POST['categoriaIncidencia'])){

                return $this->ipc('index/index.html.twig','getFecha','fechaIncidencia');
            }
            elseif (empty($_POST['descripcionIncidencia']) && empty($_POST['fechaIncidencia']) && empty($_POST['categoriaIncidencia'])){

                return $this->ipc('index/index.html.twig','getPrioridadBusqueda','prioridadIncidencia');
            }
            elseif (empty($_POST['descripcionIncidencia']) && empty($_POST['fechaIncidencia']) && empty($_POST['prioridadIncidencia'])){

                return $this->ipc('index/index.html.twig','getCategoriaBusqueda','categoriaIncidencia');
            }

        }

        return $this->ipc('index/index.html.twig','getAll','');
    }

    /**
     * @Route("/nuevaIncidencia", name="nuevaIncidencia")
     */
    public function nuevaIncidencia(){

        if (isset($_POST['descBIncidencia'])){

            $incidencia = new Incidencia($this->getDoctrine());
            $incidencia->setDescripcionBreve($_POST['descBIncidencia']);
            $incidencia->setDescripcionDetallada($_POST['descDIncidencia']);
            $incidencia->setFechaHora(date('m/d/Y g:i'));
            $incidencia->setPrioridad($_POST['prioridadNuevaIncidencia']);
            $incidencia->setCategoria($_POST['nuevacategoriaNuevaIncidencia']);
            $incidencia->setTecnico($_POST['tecnicoIncidencia']);

        }


        return $this->ipc('index/index.html.twig','getAll','');


    }

    /**
     * @Route("/ventanaNuevaIncidencia", name="ventanaNuevaIncidencia")
     */
    public function ventanaNuevaIncidencia(){

        return $this->ipc('incidencia/nuevaIncidencia.html.twig','getAll','');

    }

}

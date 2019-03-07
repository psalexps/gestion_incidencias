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

class IncidenciaController extends AbstractController{

    private function ipc($view,$get,$post,$ii){

        if ($post == '') {

            $incidencia = new Incidencia($this->getDoctrine());
            $incidencias = $incidencia->$get();
        }
        elseif ($post == 'detallesIncidencia'){

            $incidencia = new Incidencia($this->getDoctrine());
            $incidencia->setId($ii);
            $incidencias = $incidencia->$get();

            $cliente = new Cliente($this->getDoctrine());
            $cliente->setId($incidencias[0]['cliente']);
            $clientes = $cliente->getSelectId();

            $anotacion = new Anotacion($this->getDoctrine());
            $anotacion->setIncidencia($ii);
            $anotaciones = $anotacion->getAllIdIncidencia();
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
            'tipo' => $_SESSION['tipo'],
            'anotaciones' => !empty($anotaciones) ? $anotaciones : '',
            'clientes' => !empty($clientes) ? $clientes : ''
        ]);

    }

    private function comprobarLogin(){

        if (!empty($_SESSION['login']) && !empty($_SESSION['tipo'])) {

            return true;

        }
        else {

            return false;
        }

    }

    private function comprobarUsuario(){

        if ($_SESSION['tipo'] == 'empleado') {

            return true;
        }
        else {

            return false;
        }
    }

    /**
     * @Route("/incidencia", name="incidencia")
     */
    public function incidencia(){

        if ($this->comprobarLogin()){

            return $this->ipc('incidencia/detallesIncidencia.html.twig','getSelectId','detallesIncidencia',$_GET['ii']);
        }
        else {

            return $this->render('login/login.html.twig', [
                'error' => false
            ]);
        }

    }

    /**
     * @Route("/busqueda", name="busqueda")
     */
    public function busqueda(){

        if ($this->comprobarLogin()){

            if ($this->comprobarUsuario()) {

                if (isset($_POST['buscarIncidencia'])) {

                    if (empty($_POST['fechaIncidencia']) && empty($_POST['prioridadIncidencia']) && empty($_POST['categoriaIncidencia'])){

                        return $this->ipc('index/index.html.twig','getDesc','descripcionIncidencia','');
                    }
                    elseif (empty($_POST['descripcionIncidencia']) && empty($_POST['prioridadIncidencia']) && empty($_POST['categoriaIncidencia'])){

                        return $this->ipc('index/index.html.twig','getFecha','fechaIncidencia','');
                    }
                    elseif (empty($_POST['descripcionIncidencia']) && empty($_POST['fechaIncidencia']) && empty($_POST['categoriaIncidencia'])){

                        return $this->ipc('index/index.html.twig','getPrioridadBusqueda','prioridadIncidencia','');
                    }
                    elseif (empty($_POST['descripcionIncidencia']) && empty($_POST['fechaIncidencia']) && empty($_POST['prioridadIncidencia'])){

                        return $this->ipc('index/index.html.twig','getCategoriaBusqueda','categoriaIncidencia','');
                    }

                }

                return $this->ipc('index/index.html.twig','getAll','','');
            }
            else {

                return $this->ipc('index/index.html.twig', 'getAll', '','');
            }

        }
        else {

            return $this->render('login/login.html.twig', [
                'error' => false
            ]);
        }
    }

    /**
     * @Route("/nuevaIncidencia", name="nuevaIncidencia")
     */
    public function nuevaIncidencia(){

        if ($this->comprobarLogin()){

            if ($this->comprobarUsuario()) {

                if (isset($_POST['descBIncidencia'])) {

                    $cliente = new Cliente($this->getDoctrine());
                    $cliente->setNombre($_POST['nombreCliente']);
                    $cliente->setApellidos($_POST['apellidosCliente']);
                    $cliente->setEmail($_POST['emailCliente']);
                    $cliente->setTelefono($_POST['telefonoCliente']);
                    $cliente->insert();

                    $incidencia = new Incidencia($this->getDoctrine());
                    $incidencia->setDescripcionBreve($_POST['descBIncidencia']);
                    $incidencia->setDescripcionDetallada($_POST['descDIncidencia']);
                    $incidencia->setFechaHora(date('Y/m/d g:i:s'));
                    $incidencia->setPrioridad($_POST['prioridadNuevaIncidencia']);
                    $incidencia->setEstado('abierta');

                    if ($_POST['nuevacategoriaNuevaIncidencia'] == ""){

                        $incidencia->setCategoria($_POST['categoriaNuevaIncidencia']);
                    }
                    else {

                        $categoria = new Categoria($this->getDoctrine());
                        $categoria->setNombre($_POST['nuevacategoriaNuevaIncidencia']);
                        $categoria->insert();
                        $incidencia->setCategoria($categoria->getId());
                    }

                    $incidencia->setTecnico($_POST['tecnicoIncidencia']);
                    $incidencia->setCliente($cliente->getId());
                    $incidencia->insert();

                }

                return $this->ipc('index/index.html.twig', 'getAll', '','');
            }
            else {

                return $this->ipc('index/index.html.twig', 'getAll', '','');
            }

        }
        else {

            return $this->render('login/login.html.twig', [
                'error' => false
            ]);
        }
    }

    /**
     * @Route("/ventanaNuevaIncidencia", name="ventanaNuevaIncidencia")
     */
    public function ventanaNuevaIncidencia(){

        if ($this->comprobarLogin()){

            if ($this->comprobarUsuario()) {

                return $this->ipc('incidencia/nuevaIncidencia.html.twig', 'getAll', '','');
            }
            else {

                return $this->ipc('index/index.html.twig', 'getAll', '','');
            }

        }
        else {

            return $this->render('login/login.html.twig', [
                'error' => false
            ]);
        }

    }

    /**
     * @Route("/actualizarIncidencia", name="actualizarIncidencia")
     */
    public function actualizarIncidencia(){

        if ($this->comprobarLogin()){

            $cliente = new Cliente($this->getDoctrine());
            $cliente->setNombre($_POST['nombreCliente']);
            $cliente->setApellidos($_POST['apellidosCliente']);
            $cliente->setEmail($_POST['emailCliente']);
            $cliente->setTelefono($_POST['telefonoCliente']);
            $cliente->setId($_GET['ic']);
            $cliente->update();

            if ($_POST['tecnicoIncidencia'] == ""){}
            else {

                $incidencia = new Incidencia($this->getDoctrine());
                $incidencia->setTecnico($_POST['tecnicoIncidencia']);
                $incidencia->setId($_GET['ii']);
                $incidencia->update();
            }

            return $this->ipc('incidencia/detallesIncidencia.html.twig','getSelectId','detallesIncidencia',$_GET['ii']);

        }
        else {

            return $this->render('login/login.html.twig', [
                'error' => false
            ]);
        }

    }

    /**
     * @Route("/incidenciasCerradas", name="incidenciasCerradas")
     */
    public function incidenciasCerradas(){

        if ($this->comprobarLogin()){

            return $this->ipc('index/index.html.twig','getAllCerradas','','');

        }
        else {

            return $this->render('login/login.html.twig', [
                'error' => false
            ]);
        }

    }

    /**
     * @Route("/cerrarIncidencia", name="cerrarIncidencia")
     */
    public function cerrarIncidencia(){

        if ($this->comprobarLogin()){

            $incidencia = new Incidencia($this->getDoctrine());
            $incidencia->setEstado("Cerrada");
            $incidencia->setId($_GET['ii']);
            $incidencia->updateEstado();

            return $this->ipc('index/index.html.twig','getAll','','');

        }
        else {

            return $this->render('login/login.html.twig', [
                'error' => false
            ]);
        }

    }

}

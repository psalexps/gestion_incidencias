<?php

namespace App\Controller;

use App\Entity\Categoria;
use App\Entity\Incidencia;
use App\Entity\Prioridad;
use App\Entity\Usuario;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class UsuarioController extends AbstractController{

    private function ipc(){

        $incidencia = new Incidencia($this->getDoctrine());
        $incidencias = $incidencia->getAll();

        $prioridad = new Prioridad($this->getDoctrine());
        $prioridades = $prioridad->getAll();

        $categoria = new Categoria($this->getDoctrine());
        $categorias = $categoria->getAll();

        $tecnico = new Usuario($this->getDoctrine());
        $tecnicos = $tecnico->getAll();

        return $this->render('index/index.html.twig', [
            'incidencias' => $incidencias,
            'prioridades' => $prioridades,
            'categorias' => $categorias,
            'tecnicos' => $tecnicos,
            'tipo' => $_SESSION['tipo']
        ]);
    }

    /**
     * @Route("/", name="index")
     */
    public function index(){

        if (!isset($_SESSION['login']) || $_SESSION['login'] == false){

            $_SESSION['login'] = false;

            return $this->render('login/login.html.twig', [
                'error' => false
            ]);
        }
        else {

            return $this->ipc();
        }
    }

    /**
     * @Route("/login", name="login")
     */
    public function login(){

        if (isset($_POST['emailUsuario'])){

            $usuario = new Usuario($this->getDoctrine());
            $usuario->setEmail($_POST['emailUsuario']);
            $usuario->setPassword($_POST['passwordUsuario']);

            if($usuario->login()){

                $_SESSION['tipo'] = $usuario->login()[0]["tipo"];

                $_SESSION['login'] = true;

                return $this->ipc();
            }
            else {

                $_SESSION['login'] = false;

                return $this->render('login/login.html.twig', [
                    'error' => true
                ]);
            }

        }

        return $this->index();

    }

    /**
     * @Route("/loggout", name="loggout")
     */
    public function loggout(){

        $_SESSION['login'] = false;

        return $this->index();
    }
}

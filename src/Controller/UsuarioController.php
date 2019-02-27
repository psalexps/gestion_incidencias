<?php

namespace App\Controller;

use App\Entity\Incidencia;
use App\Entity\Usuario;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class UsuarioController extends AbstractController
{

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

            $incidencia = new Incidencia($this->getDoctrine());

            $incidencias = $incidencia->getAll();

            return $this->render('index/index.html.twig', [
                'incidencias' => $incidencias
            ]);

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

                $_SESSION['login'] = true;

                $incidencia = new Incidencia($this->getDoctrine());

                $incidencias = $incidencia->getAll();

                return $this->render('index/index.html.twig', [
                        'incidencias' => $incidencias
                    ]);
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

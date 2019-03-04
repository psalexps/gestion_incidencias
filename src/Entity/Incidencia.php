<?php

namespace App\Entity;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\IncidenciaRepository")
 */
class Incidencia extends ServiceEntityRepository
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $descripcionBreve;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $descripcionDetallada;

    /**
     * @ORM\Column(type="datetime")
     */
    private $fechaHora;

    /**
     * @ORM\Column(type="integer")
     */
    private $prioridad;

    /**
     * @ORM\Column(type="string", length=25)
     */
    private $estado;

    /**
     * @ORM\Column(type="integer")
     */
    private $categoria;

    /**
     * @ORM\Column(type="integer")
     */
    private $tecnico;

    /**
     * @ORM\Column(type="integer")
     */
    private $cliente;

    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Incidencia::class);
    }

    public function insert(){

        $conn = $this->getEntityManager()->getConnection();

        $sql = 'INSERT into incidencia(descripcion_breve,descripcion_detallada,fecha_hora,prioridad,estado,categoria,tecnico,cliente)
                VALUES(:descripcion_breve,:descripcion_detallada,:fecha_hora,:prioridad,:estado,:categoria,:tecnico,:cliente)';

        $stmt = $conn->prepare($sql);
        $stmt->execute([
            'descripcion_breve' => $this->descripcionBreve,
            'descripcion_detallada' => $this->descripcionDetallada,
            'fecha_hora' => $this->fechaHora,
            'prioridad' => $this->prioridad,
            'estado' => $this->estado,
            'categoria' => $this->categoria,
            'tecnico' => !empty($this->tecnico) ? $this->tecnico : NULL,
            'cliente' => $this->cliente
        ]);

    }

    public function getAll(){

        $conn = $this->getEntityManager()->getConnection();

        $sql = 'SELECT id, descripcion_breve, descripcion_detallada, fecha_hora,
                (SELECT nombre from prioridad WHERE id = prioridad) as prioridad, estado,
                (SELECT nombre from categoria WHERE id = categoria) as categoria,
                (SELECT nombre from usuario WHERE id = tecnico) as tecnico, cliente
                FROM incidencia';

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        if ($stmt->rowCount() > 0){

            return $stmt->fetchAll();
        }
        else {

            return false;
        }

    }

    public function getDesc($busqueda){

        $conn = $this->getEntityManager()->getConnection();

        $sql = 'SELECT id, descripcion_breve, descripcion_detallada, fecha_hora,
                (SELECT nombre from prioridad WHERE id = prioridad) as prioridad, estado,
                (SELECT nombre from categoria WHERE id = categoria) as categoria,
                (SELECT nombre from usuario WHERE id = tecnico) as tecnico, cliente
                FROM incidencia
                WHERE descripcion_breve LIKE "%'.$busqueda.'%"';

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        if ($stmt->rowCount() > 0){

            return $stmt->fetchAll();
        }
        else {

            return false;
        }

    }

    public function getFecha($busqueda){

        $conn = $this->getEntityManager()->getConnection();

        $sql = 'SELECT id, descripcion_breve, descripcion_detallada, fecha_hora,
                (SELECT nombre from prioridad WHERE id = prioridad) as prioridad, estado,
                (SELECT nombre from categoria WHERE id = categoria) as categoria,
                (SELECT nombre from usuario WHERE id = tecnico) as tecnico, cliente
                FROM incidencia
                WHERE fecha_hora LIKE "%'.$busqueda.'%"';

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        if ($stmt->rowCount() > 0){

            return $stmt->fetchAll();
        }
        else {

            return false;
        }

    }

    public function getPrioridadBusqueda($busqueda){

        $conn = $this->getEntityManager()->getConnection();

        $sql = 'SELECT i.id, i.descripcion_breve, i.descripcion_detallada, i.fecha_hora, p.nombre as prioridad, i.estado,
                (SELECT nombre from categoria WHERE id = categoria) as categoria, 
                (SELECT nombre from usuario WHERE id = tecnico) as tecnico, cliente
                FROM incidencia i, prioridad p
                WHERE i.prioridad = p.id and p.id = :idPrioridad';

        $stmt = $conn->prepare($sql);
        $stmt->execute([
            'idPrioridad' => $busqueda
        ]);

        if ($stmt->rowCount() > 0){

            return $stmt->fetchAll();
        }
        else {

            return false;
        }

    }

    public function getCategoriaBusqueda($busqueda){

        $conn = $this->getEntityManager()->getConnection();

        $sql = 'SELECT i.id, i.descripcion_breve, i.descripcion_detallada, i.fecha_hora,
                (SELECT nombre from prioridad WHERE id = prioridad) as prioridad, i.estado,
                c.nombre as categoria, 
                (SELECT nombre from usuario WHERE id = tecnico) as tecnico, cliente
                FROM incidencia i, categoria c
                WHERE i.categoria = c.id and c.id = :idCategoria';

        $stmt = $conn->prepare($sql);
        $stmt->execute([
            'idCategoria' => $busqueda
        ]);

        if ($stmt->rowCount() > 0){

            return $stmt->fetchAll();
        }
        else {

            return false;
        }

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getDescripcionBreve()
    {
        return $this->descripcionBreve;
    }

    /**
     * @param mixed $descripcionBreve
     */
    public function setDescripcionBreve($descripcionBreve)
    {
        $this->descripcionBreve = $descripcionBreve;
    }

    /**
     * @return mixed
     */
    public function getDescripcionDetallada()
    {
        return $this->descripcionDetallada;
    }

    /**
     * @param mixed $descripcionDetallada
     */
    public function setDescripcionDetallada($descripcionDetallada)
    {
        $this->descripcionDetallada = $descripcionDetallada;
    }

    /**
     * @return mixed
     */
    public function getFechaHora()
    {
        return $this->fechaHora;
    }

    /**
     * @param mixed $fechaHora
     */
    public function setFechaHora($fechaHora)
    {
        $this->fechaHora = $fechaHora;
    }

    /**
     * @return mixed
     */
    public function getPrioridad()
    {
        return $this->prioridad;
    }

    /**
     * @param mixed $prioridad
     */
    public function setPrioridad($prioridad)
    {
        $this->prioridad = $prioridad;
    }

    /**
     * @return mixed
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * @param mixed $estado
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;
    }

    /**
     * @return mixed
     */
    public function getCategoria()
    {
        return $this->categoria;
    }

    /**
     * @param mixed $categoria
     */
    public function setCategoria($categoria)
    {
        $this->categoria = $categoria;
    }

    /**
     * @return mixed
     */
    public function getTecnico()
    {
        return $this->tecnico;
    }

    /**
     * @param mixed $tecnico
     */
    public function setTecnico($tecnico)
    {
        $this->tecnico = $tecnico;
    }

    /**
     * @return mixed
     */
    public function getCliente()
    {
        return $this->cliente;
    }

    /**
     * @param mixed $cliente
     */
    public function setCliente($cliente)
    {
        $this->cliente = $cliente;
    }


}

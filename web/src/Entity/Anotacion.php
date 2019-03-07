<?php

namespace App\Entity;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ComentarioRepository")
 */
class Anotacion extends ServiceEntityRepository
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $descripcion;

    /**
     * @ORM\Column(type="integer")
     */
    private $incidencia;

    /**
     * @ORM\Column(type="datetime")
     */
    private $fechaHora;

    /**
     * @ORM\Column(type="integer")
     */
    private $tecnico;

    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Anotacion::class);
    }

    public function insert(){

        $conn = $this->getEntityManager()->getConnection();

        $sql = 'INSERT into anotacion(tecnico,descripcion,fecha_hora,incidencia)
                VALUES(:tecnico,:descripcion,:fecha_hora,:incidencia)';

        $stmt = $conn->prepare($sql);
        $stmt->execute([
            'tecnico' => $this->tecnico,
            'descripcion' => $this->descripcion,
            'fecha_hora' => $this->fechaHora,
            'incidencia' => $this->incidencia
        ]);

    }

    public function getAllIdIncidencia(){

        $conn = $this->getEntityManager()->getConnection();

        $sql = 'SELECT id,(SELECT nombre from usuario WHERE id = tecnico) as tecnico,descripcion,fecha_hora,incidencia FROM anotacion WHERE incidencia = :idIncidencia ORDER BY fecha_hora';

        $stmt = $conn->prepare($sql);
        $stmt->execute([
            'idIncidencia' => $this->incidencia
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
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * @param mixed $descripcion
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }

    /**
     * @return mixed
     */
    public function getIncidencia()
    {
        return $this->incidencia;
    }

    /**
     * @param mixed $incidencia
     */
    public function setIncidencia($incidencia)
    {
        $this->incidencia = $incidencia;
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



}

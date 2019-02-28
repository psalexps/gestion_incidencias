<?php

namespace App\Entity;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoriaRepository")
 */
class Categoria extends ServiceEntityRepository
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $nombre;

    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Categoria::class);
    }

    public function getAll(){

        $conn = $this->getEntityManager()->getConnection();

        $sql = 'SELECT id, nombre FROM categoria';

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        if ($stmt->rowCount() > 0){

            return $stmt->fetchAll();
        }
        else {

            return false;
        }

    }

    /**
     * @return mixed
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @param mixed $nombre
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }


}

<?php

namespace eDemy\EventBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use eDemy\MainBundle\Entity\BaseEntity;
use eDemy\EventBundle\Entity\Imagen;

/**
 * @ORM\Entity(repositoryClass="eDemy\EventBundle\Entity\EventRepository")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="Event")
 */
class Event extends BaseEntity
{
    public function __construct($em)
    {
        parent::__construct($em);
        $this->imagenes = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getNombre();
    }
    
    public function isProximo()
    {
        $interval = $this->getFecha()->diff(new \DateTime());
        if($interval->days < 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    protected $nombre;

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function showNombreInForm()
    {
        return true;
    }

    /**
     * @ORM\Column(name="descripcion", type="text", nullable=true)
     */
    protected $description;

    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @ORM\Column(name="fecha", type="date", nullable=true)
     */
    protected $fecha;

    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    public function getFecha()
    {
        return $this->fecha;
    }
    
    public function showFechaInForm()
    {
        return true;
    }

    /**
     * @ORM\Column(name="horaInicio", type="time", nullable=true)
     */
    protected $horaInicio;

    public function setHoraInicio($horaInicio)
    {
        $this->horaInicio = $horaInicio;

        return $this;
    }

    public function getHoraInicio()
    {
        return $this->horaInicio;
    }

    public function showHoraInicioInForm()
    {
        return true;
    }

    public function getStartDate()
    {
        $startDate = new \DateTime();
        if(($this->getFecha() != null) and ($this->getHoraInicio() != null)) {
            $startDate->setDate((int) $this->getFecha()->format("Y"), (int) $this->getFecha()->format("m"), (int) $this->getFecha()->format("d"));
            $startDate->setTime((int) $this->getHoraInicio()->format("H"), (int) $this->getHoraInicio()->format("i"));
            return $startDate;
        }

        return null;
    }

    /**
     * @ORM\Column(name="horaFin", type="time", nullable=true)
     */
    protected $horaFin;

    public function setHoraFin($horaFin)
    {
        $this->horaFin = $horaFin;

        return $this;
    }

    public function getHoraFin()
    {
        return $this->horaFin;
    }

    public function showHoraFinInForm()
    {
        return true;
    }

    public function getEndDate()
    {
        $endDate = new \DateTime();
        if(($this->getFecha() != null) and ($this->getHoraFin() != null)) {
            $endDate->setDate((int) $this->getFecha()->format("Y"), (int) $this->getFecha()->format("m"), (int) $this->getFecha()->format("d"));
            $endDate->setTime((int) $this->getHoraFin()->format("H"), (int) $this->getHoraFin()->format("i"));
            return $endDate;
        }
        
        return null;
    }

    /**
     * @ORM\OneToMany(targetEntity="eDemy\EventBundle\Entity\Imagen", mappedBy="event", cascade={"persist","remove"})
     */
    protected $imagenes;

    public function getImagenes()
    {
        return $this->imagenes;
    }

    public function addImagen(Imagen $imagen)
    {
        $imagen->setEvent($this);
        $this->imagenes->add($imagen);
    }

    public function removeImagen(Imagen $imagen)
    {
        $this->imagenes->removeElement($imagen);
        $this->getEntityManager()->remove($imagen);
    }

}

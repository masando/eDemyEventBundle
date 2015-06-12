<?php

namespace eDemy\EventBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;
use eDemy\MainBundle\Entity\BaseImagen;

/**
 * @ORM\Table("EventImagen")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity
 */
class Imagen extends BaseImagen
{
    public function __construct($em = null)
    {
        parent::__construct($em);
    }

    /**
    /**
     * @ORM\ManyToOne(targetEntity="eDemy\EventBundle\Entity\Event", inversedBy="imagenes")
     */
    private $event;

    public function setEvent($event)
    {
        $this->event = $event;

        return $this;
    }

    public function getEvent()
    {
        return $this->event;
    }
}

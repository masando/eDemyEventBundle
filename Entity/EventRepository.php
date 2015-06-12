<?php

namespace eDemy\EventBundle\Entity;

use Doctrine\ORM\EntityRepository;

class EventRepository extends EntityRepository
{
    public function findProximos()
    {
        $today = new \DateTime();
        $qb = $this->createQueryBuilder('e');
        $qb->andWhere('e.fecha >= :today');
        $qb->andWhere('e.published = true');
        $qb->orderBy('e.fecha','ASC');
        $qb->setParameter('today', $today);
        $query = $qb->getQuery();
        
        //die(var_dump($query->getResult()));
        return $query->getResult();
    }

    public function findAnteriores()
    {
        $today = new \DateTime();
        $qb = $this->createQueryBuilder('e');
        $qb->andWhere('e.fecha < :today');
        $qb->andWhere('e.published = true');
        $qb->orderBy('e.fecha','DESC');
        $qb->setParameter('today', $today);
        $query = $qb->getQuery();
        
        //die(var_dump($query->getResult()));
        return $query->getResult();
    }

    public function findProximo()
    {
        $today = new \DateTime();
        $qb = $this->createQueryBuilder('e');
        $qb->andWhere('e.fecha >= :today');
        $qb->andWhere('e.published = true');
        $qb->orderBy('e.fecha','ASC');
        $qb->setParameter('today', $today);
        $qb->setMaxResults(2);
        $query = $qb->getQuery();
        
        return $query->getResult();
    }

    public function findLastModified($namespace = null)
    {
        $qb = $this->createQueryBuilder('e');
        if($namespace == null) {
            $qb->andWhere('e.namespace is null');
        } else {
            $qb->andWhere('e.namespace = :namespace');
            $qb->setParameter('namespace', $namespace);
        }
        $qb->orderBy('e.updated','DESC');
        $qb->setMaxResults(1);
        $query = $qb->getQuery();

        return $query->getSingleResult();
    }
}

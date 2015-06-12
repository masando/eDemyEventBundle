<?php

namespace eDemy\EventBundle\Controller;

use eDemy\MainBundle\Controller\BaseController;
use eDemy\MainBundle\Event\ContentEvent;

class EventController extends BaseController
{
    public static function getSubscribedEvents()
    {
        return self::getSubscriptions('event', ['event'], array(
            'edemy_event_event_details' => array('onEventDetails', 0),
            'edemy_event_event_details_lastmodified' => array('onEventDetailsLastModified', 0),
            //'edemy_precontent_module' => array('onPreContentModule', 0),
            'edemy_postcontent_module' => array('onPostContentModule', 0),
        ));
    }

    public function onFrontpage(ContentEvent $event)
    {
        $this->get('edemy.meta')->setTitlePrefix("Eventos");

        $this->addEventModule($event, "frontpage.html.twig", array(
            'eventos_proximos' => $this->getRepository($event->getRoute())->findProximos(),
            'eventos_anteriores' => $this->getRepository($event->getRoute())->findAnteriores(),
        ));
    }

    public function onEventDetailsLastModified(ContentEvent $event)
    {
        $evento = $this->getRepository('edemy_event_event_index')->findLastModified($this->getNamespace());

        if($evento->getUpdated()) {
            $event->setLastModified($evento->getUpdated());
        }
    }

    public function onEventDetails(ContentEvent $event)
    {
        $entity = $this->getRepository($event->getRoute())->findOneBy(array(
            'namespace' => $this->getNamespace(),
            'slug'        => $this->getRequestParam('slug'),
        ));

        $this->get('edemy.meta')->setTitlePrefix($entity->getNombre() . ' Elda Petrer');
        $this->get('edemy.meta')->setDescription($entity->getMetaDescription());
        $this->get('edemy.meta')->setKeywords($entity->getMetaKeywords());

        $this->addEventModule($event, 'details.html.twig', array(
            'event' => $entity,
            
        ));
    }

    public function onPreContentModule(ContentEvent $event) {
        if($this->getRoute() != 'edemy_main_frontpage') {
            $this->addEventModule($event, 'precontent.html.twig', array(
                'eventos_proximos' => $this->get('doctrine.orm.entity_manager')->getRepository('eDemyEventBundle:Event')->findProximo(),
            ));
        }
        
        return true;
    }

    public function onPostContentModule(ContentEvent $event) {
        if($this->getRoute() != 'edemy_main_frontpage') {
            $this->addEventModule($event, 'postcontent.html.twig', array(
                'eventos_proximos' => $this->get('doctrine.orm.entity_manager')->getRepository('eDemyEventBundle:Event')->findProximo(),
            ));
        }
        
        return true;
    }
}
<?php

namespace App\EventListener;

use App\Entity\Figure;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\String\Slugger\SluggerInterface;

class FigureEntityListener
{
    private $slugger;
    
    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }
    
    public function prePersist(Figure $figure, LifecycleEventArgs $event)
    {
        $figure->sluggify($this->slugger);
    }
    
    public function preUpdate(Figure $figure, LifecycleEventArgs $event)
    {
        $figure->sluggify($this->slugger);
    }
}

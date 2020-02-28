<?php

namespace App\EventListener;

use App\Entity\Figure;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\String\Slugger\SluggerInterface;

class FigureChangedNotifier
{
    public function prePersist(Figure $figure, SluggerInterface $slugger): void
    {
        dump("toto");
        $figure->setSlug((string) $slugger->slug((string) $this->getName())->lower());
    }
}
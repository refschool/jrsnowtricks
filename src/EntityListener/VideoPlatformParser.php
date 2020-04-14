<?php

namespace App\EntityListener;

use App\Entity\Video;
use Doctrine\Persistence\Event\LifecycleEventArgs;

class VideoPlatformParser
{
    public function prePersist(Video $video, LifecycleEventArgs $eventArgs): void
    {

    }

    public function preUpdate(Video $video, LifecycleEventArgs $eventArgs): void
    {

    }
}

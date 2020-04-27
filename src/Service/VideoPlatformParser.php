<?php

namespace App\Service;

use App\Entity\Video;
use Doctrine\Persistence\Event\LifecycleEventArgs;

class VideoPlatformParser
{
    private $videoId;

    private $webSite;

    public function parseUrl($url): bool
    {
        $this->videoId = $this->webSite = null;

        //Traiter l'url

        $this->webSite = "YouTube";

        $this->videoId = "toto";

        return true;
    }

    public function getWebSite()
    {
        return $this->webSite;
    }

    public function setWebSite($webSite): self
    {
        $this->webSite = $webSite;

        return $this;
    }

    public function getVideoId(): string
    {
        return $this->videoId;
    }

    public function setVideoId($videoId): self
    {
        $this->videoId = $videoId;

        return $this;
    }
}

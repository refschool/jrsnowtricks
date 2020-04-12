<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PictureRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Picture
{
    const UPLOAD_DIR = 'uploads/img';

    const UPLOAD_ROOT_DIR = __DIR__.'/../../public/'.self::UPLOAD_DIR;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=5)
     */
    private $extension;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $alt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Figure", inversedBy="pictures")
     * @ORM\JoinColumn(nullable=false)
     */
    private $figure;

    /**
     * @var UploadedFile $file
     */
    private $file;

    /**
     * Simple buffer
     *
     * @var string
     */
    private $tempFileName;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getExtension(): ?string
    {
        return $this->extension;
    }

    public function setExtension(string $extension): self
    {
        $this->extension = $extension;

        return $this;
    }

    public function getAlt(): ?string
    {
        return $this->alt;
    }

    public function setAlt(string $alt): self
    {
        $this->alt = $alt;

        return $this;
    }

    public function getFigure(): ?Figure
    {
        return $this->figure;
    }

    public function setFigure(?Figure $figure): self
    {
        $this->figure = $figure;

        return $this;
    }

    public function getWebPath(): string
    {
        return self::UPLOAD_DIR.'/'.$this->id.'.'.$this->extension;
    }

    /**
     * @return mixed
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param mixed $file
     */
    public function setFile($file): self
    {
        $this->file = $file;

        if ($this->extension) {
            $this->tempFileName = $this->extension;
        }

        $this->extension = $this->alt = null;

        return $this;
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function preUploadFile(): void
    {
        if (!$this->file) {
            return;
        }

        $this->extension = $this->file->getClientOriginalExtension();
        $this->alt = explode('.', $this->file->getClientOriginalName())[0];
    }

    /**
     * @ORM\PostPersist
     * @ORM\PostUpdate
     */
    public function uploadFile(): void
    {
        if (!$this->file) {
            return;
        }

        if ($this->tempFileName) {
            $oldFile = self::UPLOAD_ROOT_DIR.'/'.$this->id.'.'.$this->tempFileName;
            if (file_exists($oldFile)) {
                unlink($oldFile);
            }
        }

        $this->file->move(self::UPLOAD_ROOT_DIR, $this->id.'.'.$this->extension);
    }

    /**
     * @ORM\PreRemove
     */
    public function preRemoveFile(): void
    {
        $this->tempFileName = $this->id.'.'.$this->extension;
    }

    /**
     * @ORM\PostRemove
     */
    public function removeFile(): void
    {
        if (file_exists(self::UPLOAD_ROOT_DIR.'/'.$this->tempFileName)) {
            unlink(self::UPLOAD_ROOT_DIR.'/'.$this->tempFileName);
        }
    }
}

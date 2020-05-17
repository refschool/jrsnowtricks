<?php

namespace App\Entity;

use App\Entity\traits\EntityIdTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PictureRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Picture
{
    use EntityIdTrait;

    const UPLOAD_DIR = 'uploads/img';

    const UPLOAD_ROOT_DIR = __DIR__.'/../../public/'.self::UPLOAD_DIR;

    /**
     * Extension of the file as the user originally uploaded.
     *
     * @ORM\Column(type="string", length=5)
     */
    private $extension;

    /**
     * Alternative text associated to the img markup. Originally the name of the file the user uploaded.
     *
     * @ORM\Column(type="string", length=50)
     */
    private $alt;

    /**
     * Figure's post this picture is related to.
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Figure", inversedBy="pictures")
     * @ORM\JoinColumn(nullable=false)
     */
    private $figure;

    /**
     * @var UploadedFile $file
     */
    private $file;

    /**
     * Simple buffer variable in order to manage the filename during upload.
     *
     * @var string
     */
    private $tempFileName;

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

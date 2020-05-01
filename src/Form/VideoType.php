<?php

namespace App\Form;

use App\Entity\Video;
use App\Service\VideoPlatformParser;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VideoType extends AbstractType
{
    private $parser;

    public function __construct(VideoPlatformParser $parser)
    {
        $this->parser = $parser;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('URL', UrlType::class, [
                'trim' => true,
                'mapped' => false,
                'attr' => ['placeholder' => 'Youtube, Dailymotion ou Vimeo'],
            ])
            ->addEventListener(FormEvents::SUBMIT, function (FormEvent $event) {
                $video = $event->getData();
                $videoUrl = $event->getForm()->get('URL')->getNormData();
                if (null !== $videoUrl) {
                    $this->parser->parseUrl($videoUrl);
                    $video->setVideoId($this->parser->getVideoId());
                    $video->setPlatform($this->parser->getWebSite());
                }
            });
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Video::class,
        ]);
    }
}

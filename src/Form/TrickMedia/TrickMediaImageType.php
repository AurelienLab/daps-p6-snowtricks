<?php

namespace App\Form\TrickMedia;

use App\Entity\TrickMedia\TrickMediaImage;
use App\Service\FileUploader;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\NotBlank;

class TrickMediaImageType extends AbstractType
{
    public function __construct(
        private FileUploader $fileUploader
    )
    {

    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('imageFile', FileType::class, [
                'label' => 'snowtricks.ui.trick_media.image.file',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new NotBlank(groups: ['new_image']),
                    new Image(
                        maxSize: '4096k',
                    )]
            ])
            ->add('alt', TextType::class, [
                'label' => 'snowtricks.ui.trick_media.image.alt',
                'required' => false,
            ])
        ;

        $builder->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {
            $data = $event->getData();
            $form = $event->getForm();

            $file = $form->get('imageFile')->getData();
            if (!empty($file)) {
                $this->fileUploader->upload($file, $data, 'trick_media_image');
            }

        });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TrickMediaImage::class,
            'validation_groups' => function (FormInterface $form): array {
                $data = $form->getData();

                if (empty($data->getImage())) {
                    return ['new_image'];
                }
                return [];
            }
        ]);
    }
}
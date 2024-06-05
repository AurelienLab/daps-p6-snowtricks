<?php

namespace App\Form;

use App\Entity\Trick;
use App\Entity\TrickCategory;
use App\Entity\TrickMedia\TrickMediaEmbed;
use App\Entity\TrickMedia\TrickMediaImage;
use App\Form\TrickMedia\TrickMediaEmbedType;
use App\Form\TrickMedia\TrickMediaImageType;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;

class TrickFormType extends AbstractType
{
    const MEDIA_TYPES = [
        TrickMediaImage::class => [
            'form_name' => 'mediasImages',
            'form_type' => TrickMediaImageType::class
        ],
        TrickMediaEmbed::class => ['form_name' => 'mediasEmbeds', 'form_type' => TrickMediaEmbedType::class],
    ];

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // Form base
        $builder
            ->add('name', TextType::class, [
                'label' => 'snowtricks.ui.name'
            ])
            ->add('featuredPictureFile', FileType::class, [
                'mapped' => false,
                'constraints' => [new Image()],
                'required' => false
            ])
            ->add('description', TextareaType::class, [
                'label' => 'snowtricks.ui.description'
            ])
            ->add('trickCategory', EntityType::class, [
                'label' => 'snowtricks.ui.category',
                'class' => TrickCategory::class,
                'choice_label' => 'name'
            ])
        ;

        // Generate media types collections
        foreach (self::MEDIA_TYPES as $mediaFormData) {
            $builder->add($mediaFormData['form_name'], CollectionType::class, [
                'entry_type' => $mediaFormData['form_type'],
                'mapped' => false,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
            ]);
        }

        // Insert current media data in corresponding collections
        $builder->addEventListener(FormEvents::POST_SET_DATA, function (FormEvent $event) {
            $data = $event->getData();
            $form = $event->getForm();

            $mediaData = [];
            foreach ($data->getMedias() as $media) {
                if (isset(self::MEDIA_TYPES[$media::class])) {
                    $mediaData[self::MEDIA_TYPES[$media::class]['form_name']][] = $media;
                }
            }

            foreach ($mediaData as $mediasFormName => $formData) {
                $form->get($mediasFormName)->setData($formData);
            }
        });

        // Merge media collections into Trick media collection
        $builder->addEventListener(FormEvents::SUBMIT, function (FormEvent $event) {
            $data = $event->getData();
            $form = $event->getForm();
            
            $medias = [];

            foreach (self::MEDIA_TYPES as $mediaFormData) {
                $mediasData = $form->get($mediaFormData['form_name'])->getData();
                $medias = array_merge($medias, $mediasData);

            }

            $data->setMedias(new ArrayCollection($medias));

            $event->setData($data);
        });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Trick::class,
        ]);
    }

}
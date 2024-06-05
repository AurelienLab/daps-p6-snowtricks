<?php

namespace App\Form\TrickMedia;

use App\Entity\TrickMedia\TrickMediaEmbed;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Regex;

class TrickMediaEmbedType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('content', TextareaType::class, [
                'constraints' => new Regex([
                    'pattern' => "/^<iframe[^>]*>\s*<\/iframe>/",
                    'message' => "Please enter a valid iFrame tag",
                ])
            ])
        ;

        // Force width and height in the iframe
        $builder->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) {
            $data = $event->getData();
            if (isset($data['content'])) {
                // Pattern to match an iframe tag and capture its attributes
                $pattern = '/<iframe([^>]*)>/';

                // Replace or add width and height attributes
                $data['content'] = preg_replace_callback($pattern, function ($matches) {
                    $attributes = $matches[1];

                    // Remove any existing width or height attributes
                    $attributes = preg_replace('/\s(width|height)\s*=\s*"\d*"/', '', $attributes);

                    // Add the new width and height attributes
                    return "<iframe$attributes width=\"160\" height=\"90\">";
                }, $data['content']);
            }

            $event->setData($data);
        });
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TrickMediaEmbed::class
        ]);
    }
}
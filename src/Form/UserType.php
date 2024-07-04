<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserType extends AbstractType
{

    /**
     * @inheritDoc
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'snowtricks.ui.email',
                'constraints' => [
                    new NotBlank(),
                    new Email()
                ]
            ])
            ->add('name', TextType::class, [
                'label' => 'snowtricks.ui.name',
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('roles', ChoiceType::class, [
                'label' => 'snowtricks.ui.role',
                'choices' => [
                    'Contributeur' => 'ROLE_USER',
                    'Administrateur' => 'ROLE_ADMIN'
                ],
                'mapped' => false,
                'data' => $builder->getData()->getRoles()[0],
            ])
            ->add('profilePictureFile', FileType::class, [
                'label' => 'snowtricks.ui.profile_picture',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new Image([
                        'maxHeight' => 1000,
                        'maxWidth' => 1000,
                        'mimeTypes' => ['image/jpeg', 'image/png']
                    ])
                ]
            ])
        ;
    }

    /**
     * @inheritDoc
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}

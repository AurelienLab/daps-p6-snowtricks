<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{


    /**
     * @inheritDoc
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'email', EmailType::class, [
                           'label' => 'snowtricks.ui.email'
                       ]
            )
            ->add(
                'name', TextType::class, [
                          'label' => 'snowtricks.ui.name'
                      ]
            )
            ->add(
                'plainPassword', PasswordType::class, [
                                   // instead of being set onto the object directly,
                                   // this is read and encoded in the controller
                                   'label' => 'snowtricks.ui.password',
                                   'mapped' => false,
                                   'attr' => ['autocomplete' => 'new-password'],
                                   'constraints' => [
                                       new NotBlank(
                                           [
                                               'message' => 'snowtricks.form.password.not_blank',
                                           ]
                                       ),
                                       new Length(
                                           [
                                               'min' => 6,
                                               'minMessage' => 'Your password should be at least {{ limit }} characters',
                                               // max length allowed by Symfony for security reasons
                                               'max' => 4096,
                                           ]
                                       ),
                                   ],
                               ]
            )
        ;
    }


    /**
     * @inheritDoc
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
                'data_class' => User::class,
            ]
        );
    }


}

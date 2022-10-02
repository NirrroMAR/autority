<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\FormBuilderInterface;
// use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'Admin' => 'ROLE_ADMIN',
                    'User' => 'ROLE_USER'
                ]
            ])
            ->add('avatar')
            ->add('password', PasswordType::class, [
                'required' => true
            ])
            // ->add('createdAt',DateTimeType::class,['widget'=>'single_text'])
            // ->add('updatedAt',DateTimeType::class,['widget'=>'single_text'])
        ;

        $builder->get('roles')
            ->addModelTransformer(new CallbackTransformer(
                fn ($rolesAsArray) => count($rolesAsArray) ? $rolesAsArray[0]: null,
                fn ($rolesAsString) => [$rolesAsString]
        ));

        // add event listener to display password field only when creating a new user
        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) {
                $form = $event->getForm();
                $user = $event->getData();
                if ($user->getId() !== null) {
                    $form->remove('password');
                }
            }
        );

    }



    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}

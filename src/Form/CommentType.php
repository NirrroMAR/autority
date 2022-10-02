<?php

namespace App\Form;

use App\Entity\Post;
use App\Entity\User;
use App\Entity\Comment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('content')
            ->add('post', EntityType::class, [
                'class' => Post::class,
                'choice_label' => 'title',
            ])
            ->add('author', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'email',
            ])
            ->add('parent', EntityType::class, [
                'class' => Comment::class,
                'choice_label' => 'content',
                'multiple' => true,
            ])
            // ->add('createdAt')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Comment::class,
        ]);
    }
}

<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Author;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', null, [
                'label' => 'Titre',
            ])
            ->add('content');

        if ($options['full']) {
            $builder
                ->add('publishedAt', DateType::class, [
                    'widget' => 'single_text',
                    'required' => false,
                ])
                ->add('writtenBy', EntityType::class, [
                    'class' => Author::class,
                    'choice_label' => 'name'
                ])
            ;
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
            'full' => true,
        ]);
    }
}

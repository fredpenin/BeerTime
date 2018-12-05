<?php

namespace App\Form;

use App\Entity\Event;
use App\Entity\Category;
use App\Entity\Place;
use App\Entity\User;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

//classes utilisées
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class AddEventFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('createdAt')//, DateType::class, array('label' => 'Date création'))
            ->add('startAt')//, DateType::class, array('label' => 'Date début'))
            ->add('endAt')//, DateType::class, array('label' => 'Date fin'))
            ->add('content')
            ->add('price')
            ->add('poster', TextType::class, array('label' => 'Image (url)'))

            ->add('place', EntityType::class, array(
                        'class' => Place::class,
                        'choice_label' => 'name'))
            ->add('categories', EntityType::class, array(
                        'class' => Category::class,
                        'choice_label' => 'name',
                        'multiple' => true,
                        'expanded' => true))
            ->add('owner', EntityType::class, array(
                        'class' => User::class,
                        'choice_label' => 'username'))
        ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}

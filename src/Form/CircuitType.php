<?php

namespace App\Form;

use App\Entity\Circuit;
use App\Entity\CircuitCategory;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class CircuitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $circuit = $builder->getData();
        $builder
            ->add('description', TextType::class, array('label' => 'Description'))
            ->add('departureCountry', TextType::class, array('label' => 'Pays de départ'))
            ->add('category', EntityType::class, array(
                'label' => 'Catégorie',
                'class' => CircuitCategory::class,
                'choice_label' => 'name'
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Circuit::class,
        ]);
    }
}

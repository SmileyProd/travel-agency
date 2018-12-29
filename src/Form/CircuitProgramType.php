<?php

namespace App\Form;

use App\Entity\CircuitProgram;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class CircuitProgramType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('departureDate', DateType::class, array('label' => 'Date de départ'))
            ->add('nbPeople', IntegerType::class, array('label' => 'Nombre de personnes'))
            ->add('price', IntegerType::class, array('label' => 'Prix (en €)'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CircuitProgram::class,
        ]);
    }
}

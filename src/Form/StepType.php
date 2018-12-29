<?php

namespace App\Form;

use App\Entity\Step;
use App\Entity\Circuit;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\LessThan;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class StepType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $step = $builder->getData();
        $circuit = $step->getCircuit();
        $builder
            ->add('stepNb', TextType::class, array(
                'label' => 'Numéro d\'étape',
                'constraints' => array(new LessThan(array('value' => $circuit->getNbSteps() + 2)))
            ))
            ->add('city', TextType::class, array('label' => 'Ville'))
            ->add('nbDays', IntegerType::class, array('label' => 'Nombre de jours'));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Step::class,
        ]);
    }
}

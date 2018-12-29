<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, array(
                'label' => 'Prénom',
                'attr' => array('placeholder' => 'Votre prénom')
            ))
            ->add('lastname', TextType::class, array(
                'label' => 'Nom',
                'attr' => array('placeholder' => 'Votre nom')
            ))
            ->add('email', EmailType::class, array(
                'label' => 'Email',
                'attr' => array('placeholder' => 'Votre email')
            ))
            ->add('subject', TextType::class, array(
                'label' => 'Sujet',
                'attr' => array('placeholder' => 'Le sujet de votre message')
            ))
            ->add('message', TextareaType::class, array(
                'label' => 'Message',
                'attr' => array('placeholder' => 'Dites-nous quelque chose', 'cols' => '30', 'rows' => '10')
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}

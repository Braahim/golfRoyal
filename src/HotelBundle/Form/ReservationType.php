<?php

namespace HotelBundle\Form;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class ReservationType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('arrive',TextType::class, array(
            'attr' => ['class ' => 'form-control m-2',
                 'placeholder' => 'Check in', 'type' => 'string', 'default' => 'datetime']
        ))
            ->add('sort',TextType::class, array(
                'attr' => ['class ' => 'form-control m-2 ',
                  'placeholder' => 'Check out']
            ))
            ->add('typeChambre',EntityType::class,array('class'=>'HotelBundle:typeChambre','choice_label'=>'lib','multiple'=>false,
                'attr' => ['class' => 'form-control form-control']));

    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'HotelBundle\Entity\Reservation'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'hotelbundle_reservation';
    }


}

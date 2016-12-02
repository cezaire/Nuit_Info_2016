<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InventaireType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre')
           // ->add('dateCreation')
            ->add('description')
            ->add('items', CollectionType::class, array(
            'label' => 'Créer les articles du colis',
            'entry_type'   => ItemType::class,
            'allow_add'    => true,
            'allow_delete' => true,
            'prototype' => true,
            'by_reference' => false
                ))
            ->add('ajouter',SubmitType::class,array('label' => 'Créer le colis'))

        ;

    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Inventaire'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_inventaire';
    }


}

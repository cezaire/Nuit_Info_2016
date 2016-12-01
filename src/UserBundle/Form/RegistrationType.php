<?php
/**
 * Created by PhpStorm.
 * User: leamsiollaid
 * Date: 04/11/2016
 * Time: 13:37
 */

namespace UserBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom',TextType::class)
            ->add('pays',TextType::class)
            ->add('email', EmailType::class)
            ->add('telephone',NumberType::class,array(
                'label' => 'Téléphone',
                'required' => false
            ))
            ->add('dateCreation', DateType::class,array(
                'widget' => 'choice',
                'years' => range(date('Y')-100,date('Y')-18),
            ))
            ->add('description',TextareaType::class)
            ->add('file',FileType::class,array(
                'label' => 'Photo de profile',
                'required'=> false
            ))
        ;
    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';
    }

    public function getBlockPrefix()
    {
        return 'axone_user_registration';
    }


    public function getName()
    {
        return $this->getBlockPrefix();
    }
}
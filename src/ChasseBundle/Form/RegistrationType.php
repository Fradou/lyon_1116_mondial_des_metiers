<?php

namespace ChasseBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;


class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('gender')->add('status')->add('age')->add('department')
            ->add('newsletter', CheckboxType::class, array(
                'label'=> 'Recevoir la newsletter ?',
                'required' => false));
    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';
    }

    public function getBlockPrefix()
    {
        return 'app_user_registration';
    }

    public function getGender()
    {
        return $this->getBlockPrefix();
    }

}
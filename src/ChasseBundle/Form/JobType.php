<?php

namespace ChasseBundle\Form;

use ChasseBundle\ChasseBundle;
use ChasseBundle\Entity\Job;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class JobType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name')->add('domain', EntityType::class, array(
            'class' => 'ChasseBundle:Job',
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('j')
                    ->select('j.domain')
                    ->distinct('true');
            },
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ChasseBundle\Entity\Job',
            'domains' => null
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'chassebundle_job';
    }


}

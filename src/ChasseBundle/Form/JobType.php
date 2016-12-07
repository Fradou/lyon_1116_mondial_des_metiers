<?php

namespace ChasseBundle\Form;

use ChasseBundle\Entity\Job;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class JobType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('domain', EntityType::class, array(
        'class' => 'ChasseBundle:Job',
        'query_builder' => function (EntityRepository $er) {
            $qb = $er->createQueryBuilder('j')
            ->distinct('true');
            return $qb;

        },
        'choice_label' => 'domain',
        'multiple' => false,
        'expanded' => false));

    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ChasseBundle\Entity\Job'
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

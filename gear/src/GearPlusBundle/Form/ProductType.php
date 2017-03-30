<?php

namespace GearPlusBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', null, array('required' => false))
            ->add('description', null, array('required' => false))
            ->add('prix', null, array('required' => false))
            ->add('charisme', null, array('required' => false))
            ->add('intelligence', null, array('required' => false))
            ->add('beaute', null, array('required' => false))
            ->add('avatar', null, array('required' => false))
            ->add('user', null, array('required' => false))
            ->add('category', null, array('required' => false))
            ->add('submit', SubmitType::class);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GearPlusBundle\Entity\Product'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'gearplusbundle_product';
    }


}

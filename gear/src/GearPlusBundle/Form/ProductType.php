<?php

namespace GearPlusBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
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
            ->add('title', null, array('label' => 'Titre','required' => false))
            ->add('description', null, array('label' => 'Description du produit','required' => false))
            ->add('prix', null, array('label' => 'Prix', 'required' => false))
            ->add('charisme', null, array('label' => 'Bonus Charisme', 'required' => false))
            ->add('intelligence', null, array('label' => 'Bonus Intelligence', 'required' => false))
            ->add('beaute', null, array('label' => 'Bonus Beauté', 'required' => false))
            ->add('avatar', FileType::class, array('label' => 'Photo du produit','required' => false,'data_class' => null))
            ->add('user', null, array('label' => 'Utilisateur','required' => false))
            ->add('category', null, array('label' => 'Categorie du produit','required' => false))
            ->add('submit', SubmitType::class, array('label' => 'Envoyer'));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GearPlusBundle\Entity\Product',
            'csrf_protection' => false,
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

<?php

namespace Jet\ShopBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class SubcategoryType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('category')
        ;
    }

    public function getName()
    {
        return 'jet_shopbundle_subcategorytype';
    }
}

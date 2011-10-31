<?php

namespace Jet\ShopBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('price')
            ->add('size_list')
            ->add('comment')
            ->add('item_number')
            ->add('file')
            ->add('category')
            ->add('subcategory')
        ;
    }

    public function getName()
    {
        return 'jet_shopbundle_producttype';
    }
}

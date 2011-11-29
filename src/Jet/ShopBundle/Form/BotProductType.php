<?php

namespace Jet\ShopBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class BotProductType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('urlproduct')
            ->add('checked')
            ->add('subcategory')
            ->add('category')
        ;
    }

    public function getName()
    {
        return 'jet_shopbundle_botproducttype';
    }
}

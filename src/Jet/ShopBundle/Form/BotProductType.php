<?php

namespace Jet\ShopBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class BotProductType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('subcategory51bab')
            ->add('category')
            ->add('subcategory')
        ;
    }

    public function getName()
    {
        return 'jet_shopbundle_botproducttype';
    }
}

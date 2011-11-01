<?php

namespace Jet\ShopBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class SliderType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('file')
            ->add('category')
        ;
    }

    public function getName()
    {
        return 'jet_shopbundle_slidertype';
    }
}

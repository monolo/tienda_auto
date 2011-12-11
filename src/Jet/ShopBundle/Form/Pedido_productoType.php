<?php

namespace Jet\ShopBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class Pedido_productoType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('quantity')
            ->add('size_list')
        ;
    }

    public function getName()
    {
        return 'jet_shopbundle_pedido_productotype';
    }
}
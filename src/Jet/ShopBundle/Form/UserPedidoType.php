<?php

namespace Jet\ShopBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class UserPedidoType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('surname')
            ->add('adress')
            ->add('numero')
            ->add('piso')
            ->add('puerta')
            ->add('poblacion')
            ->add('provincia')
            ->add('codigo_postal')
            ->add('email', 'email')
            ->add('publicidad')
        ;
    }

    public function getName()
    {
        return 'jet_shopbundle_userpedidotype';
    }
}
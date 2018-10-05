<?php

/*
 * Nexxus Stock Keeping (online voorraad beheer software)
 * Copyright (C) 2018 Copiatek Scan & Computer Solution BV
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see licenses.
 *
 * Copiatek – info@copiatek.nl – Postbus 547 2501 CM Den Haag
 */

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\OptionsResolver\OptionsResolver;

use AppBundle\Entity\PurchaseOrder;

class PurchaseOrderForm extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('orderNr', TextType::class)
            ->add('status', EntityType::class, [
                'class' => 'AppBundle:OrderStatus',
                'choice_label' => 'name'
            ])
            ->add('supplier', EntityType::class, [
                'class' => 'AppBundle:Supplier',
                'choice_label' => 'name',
                'label' => 'Select',
                'required' => false
            ])
            ->add('newSupplier', SupplierForm::class, [
                'mapped' => false
            ])
            ->add('newOrExistingSupplier', ChoiceType::class, [
                'label' => false,
                'mapped' => false,
                'expanded' => true,
                'multiple' => false,
                'data' => 'existing',
                'choices' => [
                    'Existing' => 'existing',
                    'New' => 'new',
                ]
            ])
            ->add('newProduct',  EntityType::class, [
                'required' => false,
                'mapped' => false,
                'class' => 'AppBundle:ProductType',
                'choice_label' => 'name',
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Save Changes',
                'attr' => [
                    'class' => 'btn-success',
                ]
            ]);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => PurchaseOrder::class,
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id'   => 'porder'
        ));
    }
}
<?php

namespace App\Form;

use App\Entity\Cheque;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChequeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date', DateTimeType::class, [
                    'label' => "Дата",
                    'attr'=> ['class' => 'input']
                ]
            )
            ->add('shop', TextType::class, [
                    'label' => "Магазин",
                    'attr'=> ['class' => 'input']
                ]
            )
            ->add('products', CollectionType::class, [
                    'label' => "Продукты",
                    'entry_type' => ProductType::class,
                    'entry_options' => ['label' => false],
                ]
            )
            ->add('customerGuest', null, [
                    'label' => "Покупатель",
                    'attr'=> ['class' => 'input']
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Cheque::class,
        ]);
    }
}

<?php

namespace App\Form;

use App\Entity\Guest;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GuestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                    'label' => "Имя",
                    'attr'=> ['class' => 'input']
                ]
            )
            ->add('phone', TextType::class, [
                    'label' => "Телефон",
                    'attr'=> ['class' => 'input']
                ]
            )
            ->add('products', null, [
                    'label' => "Продукты",
                    'attr'=> ['class' => 'input']
                ]
            )
            ->add('byUser', null, [
                    'label' => "Пользователь",
                    'attr'=> ['class' => 'input']
                ]
            )


        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Guest::class,
        ]);
    }
}

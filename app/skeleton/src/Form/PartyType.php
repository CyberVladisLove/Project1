<?php

namespace App\Form;

use App\Entity\Party;
use Doctrine\DBAL\Types\DateTimeImmutableType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class PartyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                    'label' => "Имя",
                    'attr'=> ['class' => 'input']
                ]
            )
            ->add('dateAt', DateTimeType::class, [
                    'label' => "Дата",
                    'attr'=> ['class' => 'input']
                ]
            )
            ->add('location', TextType::class, [
                    'label' => "Место",
                    'attr'=> ['class' => 'input']
                ]
            )
            ->add('guests', null, [
                    'label' => "Гости",
                    'attr'=> ['class' => 'input']
                ]
            );

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Party::class,
        ]);
    }
}

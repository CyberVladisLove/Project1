<?php

namespace App\Form;

use App\Entity\Product;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Query\Expr\Select;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => "Имя"
                ]
            )
            ->add('price', IntegerType::class, [
                'label' => "Цена"
                ]
            )
            ->add('count', NumberType::class, [
                    'label' => "Количество"
                ]
            )
            ->add('cheque', null, [
                    'label' => "Чек"
                ]
            )
            ->add('guests',null, [
                    'label' => "Гости"

                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}

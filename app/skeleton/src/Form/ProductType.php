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
                'label' => "Имя",
                    'attr'=> ['class' => 'input']
                ]
            )
            ->add('price', IntegerType::class, [
                'label' => "Цена",
                    'attr'=> ['class' => 'input']
                ]
            )
            ->add('count', NumberType::class, [
                    'label' => "Количество",
                    'attr'=> ['class' => 'input']
                ]
            )
            ->add('cheque', null, [
                    'label' => "Чек",
                    'attr'=> ['class' => 'input']
                ]
            )
            ->add('guests',null, [
                    'label' => "Гости",
                    'attr'=> ['class' => 'input']

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

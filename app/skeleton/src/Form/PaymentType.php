<?php

namespace App\Form;

use App\Entity\Payment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\DateTime;

class PaymentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date', DateTimeType::class, [
                    'label' => "Дата",
                    'attr'=> ['class' => 'input']
                ]
            )
            ->add('value', IntegerType::class, [
                    'label' => "Сумма",
                    'attr'=> ['class' => 'input']
                ]
            )
            ->add('fromGuest', GuestType::class, [
                    'label' => "Отправитель",
                    'attr'=> ['class' => 'form_input']
                ]
            )
            ->add('toGuest', null, [
                    'label' => "Получатель",
                    'attr'=> ['class' => 'input']
                ]
            )


        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Payment::class,
        ]);
    }
}

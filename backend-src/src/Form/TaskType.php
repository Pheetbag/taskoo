<?php

namespace App\Form;

use App\Entity\Task;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class TaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'required' => true,
                'constraints' => [
                    new NotBlank(),
                    new Length(['max' => 140])
                ]
            ])
            ->add('description', TextType::class, [
                'required' => false,
                'constraints' => [
                    new Length(['max' => 300])
                ]
            ])
            ->add('position_index', IntegerType::class, [
                'constraints' => [
                    new NotBlank()
                ]
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Task::class,
            'constraints' => new UniqueEntity(['fields' => 'position_index'])
        ]);
    }
}

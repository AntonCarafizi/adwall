<?php

namespace AppBundle\Form;

use AppBundle\Entity\Category;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ItemType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'label' => 'Select category of new item: ',
                'placeholder' => 'Choose a category',
                'choice_label' => 'name',
                'required' => true,
            ])
            ->add('title', TextType::class, [
                'label' => 'Title: ',
                'required' => true,
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description: ',
                'required' => true,
            ])
            ->add('price', TextType::class, [
                'label' => 'Price: ',
                'required' => true,
            ])
            ->add('isActive', CheckboxType::class, [
                'label' => 'Is active: ',
            ])
            ->add('zipCode', TextType::class, [
                'label' => 'Zip Code: ',
            ])
            ->add('address', TextType::class, [
                'label' => 'Address: ',
            ])
            ->add('phoneNumber', TextType::class, [
                'label' => 'Phone number: ',
            ])
            ->add('images', FileType::class, [
                'attr' => [
                    'accept' => 'image/*',
                    'multiple' => 'multiple'
                ],
                'label' => 'Upload Images: ',
                'required' => false,
            ])
            ->add('save', SubmitType::class, [
                //'label' => 'Create item',
            ]);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Item'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_item';
    }


}

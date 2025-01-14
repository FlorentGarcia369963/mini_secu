<?php

namespace App\Form;

use App\Entity\Requests;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class RequestFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('message', TextareaType::class, [
                'label' => 'Votre message',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Entrez votre message',
                    'rows' => 5,
                ]
            ])
            ->add('proof', FileType::class, [
                'label' => 'Joignez une facture acquittée',
                'mapped' => false,
                'required' => true,
                'constraints' => [
                    new Assert\File([
                        'maxSize' => '5M',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'application/pdf',
                        ],
                        'mimeTypesMessage' => 'Le format du fichier doit être valide (jpeg, png, pdf) '
                    ]),
                ],
                'attr' => [
                    'accept' => '.jpg,.jpeg,.png,.pdf',
                ],
            ])
            ->add('prescription', FileType::class, [
                'label' => 'Joignez une éventuelle prescription',
                'mapped' => false,
                'required' => true,
                'constraints' => [
                    new Assert\File([
                        'maxSize' => '5M',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'application/pdf',
                        ],
                        'mimeTypesMessage' => 'Le format du fichier doit être valide (jpeg, png, pdf) '
                    ]),
                ],
                'attr' => [
                    'accept' => '.jpg,.jpeg,.png,.pdf',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Requests::class,
        ]);
    }
}

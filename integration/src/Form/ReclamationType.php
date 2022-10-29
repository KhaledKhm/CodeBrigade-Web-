<?php

namespace App\Form;

use App\Entity\Reclamation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
class ReclamationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('imageFile',FileType::class,[
                'required'=>False
            ])

            ->add('Subject', ChoiceType::class,array(
                'choices'  => array(
                    ' choix1' => 'choix1',
                    ' choix2' => 'choix2',
                    ' choix3' => 'choix3',
                    ' choix4' => 'choix4',
                                    ),
                                                                )
                )

            ->add('defauult', ChoiceType::class,array(
                    'choices'  => array(
                        ' choi1' => 'choi1',
                        ' choi2' => 'choi2',
                        ' choi3' => 'choi3',
                        ' choi4' => 'choi4',
                    ),
                )
            )


            ->add('commentaire')

                 ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Reclamation::class,
        ]);
    }
}

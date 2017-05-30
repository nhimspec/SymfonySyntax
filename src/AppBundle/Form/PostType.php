<?php

namespace AppBundle\Form;

use AppBundle\Entity\Post;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, array(
                'attr' => array('autofocus' => true),
                'label' => 'Title',
            ))
            ->add('thumbnail', VichImageType::class, array(
                'required' => false,
                'label' => 'Thumbnail Image',
                'allow_delete' => false,
                'download_link' => false,
                'attr' => array('class' => 'upload_thumbnail'),
            ))
            ->add('summary', TextareaType::class, array(
                'label' => 'Summary'
            ))
            ->add('content', CKEditorType::class, array(
                'config_name' => 'ck_blog_config'
            ))
            ->add('authorEmail', EmailType::class, array(
                'label' => 'Author Email'
            ))
            ->add('publishedAt', 'AppBundle\Form\Type\DateTimePickerType', array(
                'label' => 'Published At',
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Post::class,
        ));
    }
}
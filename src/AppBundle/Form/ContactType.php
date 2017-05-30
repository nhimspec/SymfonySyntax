<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array(
                'attr' => array('placeholder' => 'Your Name'),
                'constraints' => array(
                    new NotBlank(array("message" => "Please provide your name"))
                ),
            ))
            ->add('email', EmailType::class, array(
                'attr' => array('placeholder' => 'Your Email'),
                'constraints' => array(
                    new NotBlank(array("message" => "Please provide a valid email")),
                    new Email(array("message" => "Your email doesn't seems to be valid"))
                ),
            ))
            ->add('subject', TextType::class, array(
                'attr' => array('placeholder' => 'Your Subject'),
                'constraints' => array(
                    new NotBlank(array("message" => "Please give a Subject"))
                ),
            ))
            ->add('message', TextareaType::class, array(
                'attr' => array('placeholder' => 'Your Message'),
                'constraints' => array(
                    new NotBlank(array("message" => "Please provide a message here")),
                ),
            ));
    }
}
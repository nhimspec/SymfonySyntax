<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

class CreateUserCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:create-user')
            ->setDescription('Create a new user.')
            ->setHelp('This command allows you to create a user...')
            ->addArgument('username', InputArgument::REQUIRED, 'The username of the user.')
            ->addArgument('email', InputArgument::REQUIRED, 'The email of the user.')
            ->addArgument('password', InputArgument::REQUIRED, 'The password of the user.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln([
            'User Creator',
            '============',
            '',
        ]);

        $username = $input->getArgument('username');
        $email = $input->getArgument('email');
        $plainPassword = $input->getArgument('password');
        
        // outputs a message followed by a "\n"
        $output->writeln('Whoa! You are about to create a user.');
        $output->writeln('Username: ' . $username);
        $output->writeln('Email: ' . $email);
        $output->writeln('Password: ' . $plainPassword);

        $userManager = $this->getContainer()->get('fos_user.user_manager');
        $user = $userManager->createUser();

        $user->setEnabled(true);
        $user->setUsername($username);
        $user->setEmail($email);
        $encoder = $this->getContainer()->get('security.password_encoder');
        $password = $encoder->encodePassword($user, $plainPassword);
        $user->setPassword($password);

        $userManager->updateUser($user);
    }
}
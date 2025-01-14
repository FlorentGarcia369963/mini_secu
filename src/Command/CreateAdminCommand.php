<?php

namespace App\Command;

use App\Service\CreateStaffService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:create-admin',
    description: 'Create a new admin user',
)]
class CreateAdminCommand extends Command
{
    public function __construct(
        private readonly CreateStaffService $createStaffService
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('lastName', InputArgument::REQUIRED, 'Lastname of the admin user')
            ->addArgument('email', InputArgument::REQUIRED, 'Email of the admin user')
            ->addArgument('password', InputArgument::REQUIRED, 'Password of the admin user')

        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $lastName = $input->getArgument('lastName');
        $email = $input->getArgument('email');
        $password = $input->getArgument('password');

        $this->createStaffService->create('ROLE_ADMIN', $lastName, $email, $password);



        $io->success('Admin created successfully');

        return Command::SUCCESS;
    }
}

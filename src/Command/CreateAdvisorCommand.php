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
    name: 'app:create-advisor',
    description: 'Create a new advisor user',
)]
class CreateAdvisorCommand extends Command
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
        ->addArgument('lastName', InputArgument::REQUIRED, 'Lastname of the advisor user')
        ->addArgument('email', InputArgument::REQUIRED, 'Email of the advisor user')
        ->addArgument('password', InputArgument::REQUIRED, 'Password of the advisor user')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $lastName = $input->getArgument('lastName');
        $email = $input->getArgument('email');
        $password = $input->getArgument('password');

        $this->createStaffService->create('ROLE_ADVISOR', $lastName, $email, $password);
       

        $io->success('Advisor created successfully');

        return Command::SUCCESS;
    }
}

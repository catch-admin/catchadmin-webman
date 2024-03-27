<?php
namespace app\command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


class Controller extends Command
{
    protected static $defaultName = 'catch:controller';
    protected function configure(): void
    {
        $this->setName('catch:controller')
            ->addArgument('name', InputArgument::REQUIRED, 'controller name')
            ->setDescription('create controller');
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $name = $input->getArgument('name');

        $controller = new \app\admin\support\generate\Controller($name);

        file_put_contents('aaa.php', $controller->generate());

        return self::SUCCESS;
    }
}

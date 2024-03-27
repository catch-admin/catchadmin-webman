<?php
namespace app\command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use app\admin\support\generate\Generator;
use think\helper\Str;
use Webman\Config;

class Model extends Command
{
    protected static $defaultName = 'catch:model';
    protected $output;

    protected $input;

    protected function configure()
    {
        $this->setName('catch:model')
            ->addArgument('name', InputArgument::REQUIRED, 'model name')
            ->addOption('table', '-t', InputArgument::OPTIONAL, 'table name')
            ->setDescription('create controller');
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->input = $input;
        $this->output = $output;

        $name = $this->input->getArgument('name');

        $table = $this->input->getOption('table');

        $model = new \app\admin\support\generate\model($name);

        $model->setTable($table);

        file_put_contents('aaa.php', $model->generate());

        return self::SUCCESS;
    }
}

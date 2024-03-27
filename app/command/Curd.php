<?php
namespace app\command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use app\admin\support\generate\Generator;


class Curd extends Command
{

    protected static $defaultName = 'catch:curd';

    protected function configure()
    {
        $this->setName('catch:curd')
            ->addArgument('table', InputArgument::REQUIRED, '表名')
            ->addOption('model', '-m', InputArgument::OPTIONAL, '模型名称')
            ->addOption('controller', '-c', InputArgument::OPTIONAL, '控制器名称')
            ->addOption('delete', '-d', InputArgument::OPTIONAL, '删除文件')
            ->addOption('force', '-f', InputArgument::OPTIONAL, '强制覆盖')
            ->setDescription('create controller');
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $table = $input->getArgument('table');

        $modelFromTable = $this->parseTable($table);

        $model = $input->getOption('model');
        $controller = $input->getOption('controller');
        $delete = $input->hasOption('delete');
        $force = $input->hasOption('force');

        if (!$model) {
            $model = $modelFromTable;
        }

        if (!$controller) {
            $controller = $model;
        }

        $generator = new Generator($model, $controller, $table);

        $res = $generator->generate();

        foreach ($res as $value) {
            $output->writeln($value . ' 创建成功');
        }

        return self::SUCCESS;
    }


    protected function parseTable($table): string
    {
        $table = tableWithoutPrefix($table);

        $model = '';

        if (str_contains($table, '_')) {
            foreach (explode('_', $table) as $value) {
                $model .= ucfirst($value);
            }
        } else {
            $model = ucfirst($table);
        }

        return $model;
    }
}

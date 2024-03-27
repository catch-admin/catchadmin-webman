<?php
namespace app\command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use app\admin\support\generate\Generator;
use think\helper\Str;
use Webman\Config;


class InstallWeb extends Command
{
    protected static $defaultName = 'catch:install:web';

    protected string $webRepo = 'https://gitee.com/catchadmin/catch-admin-vue.git';

    protected $output;

    protected $input;
    protected function configure()
    {
        $this->setName('catch:install:web')
            ->setDescription('安装前端项目');
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->input = $input;
        $this->output = $output;

        $webPath = $this->app->getRootPath(). DIRECTORY_SEPARATOR . 'web';

        $appDomain = env('APP_HOST') . '/api';

        if (! is_dir($webPath)) {
            $this->output->writeln('下载前端项目');

            shell_exec("git clone {$this->webRepo} web");

            if (is_dir($webPath)) {
                $this->output->writeln('下载前端项目成功');
                $this->output->writeln('设置镜像源');
                shell_exec('yarn config set registry https://registry.npmmirror.com');
                $this->output->writeln('安装前端依赖，如果安装失败，请检查是否已安装了前端 yarn 管理工具，或者因为网络等原因');
                shell_exec('cd ' . $this->app->getRootPath() . DIRECTORY_SEPARATOR . 'web && yarn install');
                $this->output->writeln('手动启动使用 yarn dev');
                $this->output->writeln('项目启动后不要忘记设置 web/.env 里面的环境变量 VITE_BASE_URL');
                $this->output->writeln('安装前端依赖成功，开始启动前端项目');
                file_put_contents($webPath . DIRECTORY_SEPARATOR . '.env', <<<STR
VITE_BASE_URL=$appDomain
VITE_APP_NAME=后台管理
STR
                );
                shell_exec("cd {$webPath} && yarn dev");
            } else {
                $this->output->error('下载前端项目失败, 请到该仓库下载 https://gitee.com/catchadmin/catch-admin-vue');
            }
        }

        return self::SUCCESS;
    }
}

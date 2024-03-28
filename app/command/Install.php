<?php
namespace app\command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use app\admin\support\generate\Generator;
use Symfony\Component\Console\Question\Question;
use think\helper\Str;
use Webman\Config;

class Install extends Command
{
    protected static $defaultName = 'catch:install';

    protected string $webRepo = 'https://gitee.com/catchadmin/catch-admin-vue.git';
    protected array $databaseLink = [];

    protected string $appDomain = '';

    protected $output;

    protected $input;

    protected function configure()
    {
        $this->setName('catch:install')
            ->addOption('reinstall', '-r',InputArgument::OPTIONAL, 'reinstall back')
            ->setDescription('install project');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->input = $input;
        $this->output = $output;

        if ($input->getOption('reinstall')) {
            $this->reInstall();
            $this->project();
        } else {

            $this->detectionEnvironment();

            $this->firstStep();

            $this->finished();

            $this->project();
        }

        return self::SUCCESS;
    }

    protected function detectionEnvironment(): void
    {
        $this->output->writeln('environment begin to check...');

        if (version_compare(PHP_VERSION, '8.0.0', '<')) {
            $this->output->error('php version should >= 8.0.0');
            exit();
        }

        $this->output->writeln('php version ' . PHP_VERSION);

        if (!extension_loaded('mbstring')) {
            $this->output->error('mbstring extension not install');exit();
        }
        $this->output->writeln('mbstring extension is installed');

        if (!extension_loaded('json')) {
            $this->output->error('json extension not install');
            exit();
        }
        $this->output->writeln('json extension is installed');

        if (!extension_loaded('openssl')) {
            $this->output->error('openssl extension not install');
            exit();
        }
        $this->output->writeln('openssl extension is installed');

        if (!extension_loaded('pdo')) {
            $this->output->error('pdo extension not install');
            exit();
        }
        $this->output->writeln('pdo extension is installed');

        if (!extension_loaded('xml')) {
            $this->output->error('xml extension not install');
            exit();
        }

        $this->output->writeln('xml extension is installed');

        $this->output->writeln('🎉 environment checking finished');
    }


    protected function firstStep()
    {
        if (file_exists(base_path() .DIRECTORY_SEPARATOR . '.env')) {
            // return false;
        }

        // 设置 app domain
        $appDomain = strtolower($this->ask('👉 first, you should set app domain: '));
        if (!str_contains($appDomain, 'http')) {
            $appDomain = 'http://' . $appDomain;
        }

        $this->appDomain = $appDomain;

        $answer = strtolower($this->ask( '🤔️ Did You Need to Set Database information? (Y/N): ', 'Y'));

        if ($answer === 'y' || $answer === 'yes') {
            $charset = $this->ask('👉 please input database charset, default (utf8mb4):', 'utf8mb4');
            $database = '';
            while (!$database) {
                $database = $this->ask( '👉 please input database name: ');
                if ($database) {
                    break;
                }
            }
            $host = $this->ask('👉 please input database host, default (127.0.0.1):', '127.0.0.1');
            $port = $this->ask('👉 please input database host port, default (3306):', '3306');
            // $prefix = $this->output->ask($this->input, '👉 please input table prefix, default (null):') ? : '';
            $username = $this->ask('👉 please input database username default (root): ', 'root');
            $password = '';
            $tryTimes = 0;
            while (!$password) {
                $password = $this->ask('👉 please input database password: ');
                if ($password) {
                    break;
                }
                // 尝试三次以上未填写，视为密码空
                $tryTimes++;
                if (!$password && $tryTimes > 2) {
                    break;
                }
            }

            $this->databaseLink = [$host, $database, $username, $password, $port, $charset];

            $this->generateEnvFile($host, $database, $username, $password, $port, $charset, $appDomain);
        }
    }


    protected function finished(): void
    {
        // todo something
        // create jwt

        $this->cloneWeb();
    }


    protected function generateEnvFile($host, $database, $username, $password, $port, $charset, $appDomain): void
    {
        try {
            $env = \parse_ini_file(base_path() . DIRECTORY_SEPARATOR. '.example.env', true);

            $env['APP_HOST'] = $appDomain;
            $env['DB_HOST'] = $host;
            $env['DB_NAME'] = $database;
            $env['DB_USER'] = $username;
            $env['DB_PASS'] = $password;
            $env['DB_PORT'] = $port;
            $env['DB_CHARSET'] = $charset;

            # JWT 密钥
            $env['JWT_SECRET'] = md5(Str::random(8));

            $dotEnv = '';
            foreach ($env as $key => $e) {
                if (is_string($e)) {
                    $dotEnv .= sprintf('%s=%s', $key, $e === '1' ? 'true' : ($e === '' ? 'false' : $e));
                    $dotEnv .= PHP_EOL;
                } else {
                    $dotEnv .= sprintf('[%s]', $key);
                    foreach ($e as $k => $v) {
                        $dotEnv .= sprintf('%s=%s', $k, $v === '1' ? 'true' : ($v === '' ? 'false' : $v)) ;
                    }

                    $dotEnv .= PHP_EOL;
                }
            }


            if ($this->getEnvFile()) {
                $this->output->writeln('env file has been generated');
            }
            $mysql = new \mysqli($host, $username, $password, null, $port);
            if ($mysql->query(sprintf('CREATE DATABASE IF NOT EXISTS %s DEFAULT CHARSET %s COLLATE %s_general_ci;',
                $database, $charset, $charset))) {
                $this->output->writeln(sprintf('🎉 create database %s successfully', $database));
            } else {
                $this->output->writeln(sprintf('create database %s failed，you need create database first by yourself', $database));
            }

            $mysql->select_db($database);
            // 导入 SQL
            $mysql->multi_query(file_get_contents(base_path() . DIRECTORY_SEPARATOR . 'admin.sql'));
        } catch (\Exception $e) {
            $this->output->writeln($e->getMessage());
            exit(0);
        }

        file_put_contents($this->getEnvFilePath(), $dotEnv);
    }

    protected function getEnvFile(): string
    {
        return file_exists($this->getEnvFilePath()) ? $this->getEnvFilePath() : '';
    }


    protected function project()
    {
        $year = date('Y');

        $this->output->writeln('🎉 project is installed, welcome!');

        $this->output->writeln(sprintf('
 /-------------------- welcome to use -------------------------\                     
|               __       __       ___       __          _      |
|   _________ _/ /______/ /_     /   | ____/ /___ ___  (_)___  |
|  / ___/ __ `/ __/ ___/ __ \   / /| |/ __  / __ `__ \/ / __ \ |
| / /__/ /_/ / /_/ /__/ / / /  / ___ / /_/ / / / / / / / / / / |
| \___/\__,_/\__/\___/_/ /_/  /_/  |_\__,_/_/ /_/ /_/_/_/ /_/  |
|                                                              |   
 \ __ __ __ __ _ __ _ __ enjoy it ! _ __ __ __ __ __ __ ___ _ @ 2017 ～ %s
 初始账号: catch@admin.com
 初始密码: catchadmin                                             
', $year));
        exit(0);
    }


    protected function reInstall(): void
    {
        $ask = strtolower($this->output->ask($this->input,'reset project? (Y/N)'));

        if ($ask === 'y' || $ask === 'yes' ) {
            if (file_exists($this->getEnvFilePath())) {
                unlink($this->getEnvFilePath());
            }
        }
    }

    /**
     * 获取 env path
     *
     * @time 2020年04月06日
     * @return string
     */
    protected function getEnvFilePath(): string
    {
        return base_path() . DIRECTORY_SEPARATOR . '.env';
    }


    protected function cloneWeb(): void
    {
        $webPath = base_path(). DIRECTORY_SEPARATOR . 'web';

        if (! is_dir($webPath)) {
            $this->output->writeln('下载前端项目');

            shell_exec("git clone {$this->webRepo} web");

            if (is_dir($webPath)) {
                $this->output->writeln('下载前端项目成功');
                $this->output->writeln('设置镜像源');
                shell_exec('yarn config set registry https://registry.npmmirror.com');
                $this->output->writeln('安装前端依赖，如果安装失败，请检查是否已安装了前端 yarn 管理工具，或者因为网络等原因');
                shell_exec('cd ' . base_path() . DIRECTORY_SEPARATOR . 'web && yarn install');
                $this->output->writeln('手动启动使用 yarn dev');
                $this->output->writeln('项目启动后不要忘记设置 web/.env 里面的环境变量 VITE_BASE_URL');
                $this->output->writeln('安装前端依赖成功，开始启动前端项目');
                file_put_contents($webPath . DIRECTORY_SEPARATOR . '.env', <<<STR
VITE_BASE_URL=$this->appDomain/api
VITE_APP_NAME=后台管理
STR
);
                shell_exec("cd {$webPath} && yarn dev");
            } else {
                $this->output->error('下载前端项目失败, 请到该仓库下载 https://gitee.com/catchadmin/catch-admin-vue');
            }
        }
    }

    public function ask(string  $q, string $default = null)
    {
        $helper = $this->getHelper('question');

        $question = new Question($q  . ': ' . PHP_EOL, $default);

        return $helper->ask($this->input, $this->output, $question);
    }
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\Admin\HomeController;
class Test extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
//    protected $signature = 'command:name';
    protected $signature = 'test:data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'test data';
    /**
     * 计算数据服务的 service 属性
     *这里由于要用到我们的逻辑，所以提前定义一下，方便下面使用
     * @var CalculateDataService
     */
    protected $service;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    //这个是laravel自带的构造方法。初始状态下是空的。
    //我这里由于要调用CalculateDataService 类的一个方法，所有就用依赖注入的方式引入了一下。
    public function __construct()
    {
        parent::__construct();
        // 初始化代码写到这里，也没什么
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $home = new HomeController();
        $home->create_user_num();
    }
}

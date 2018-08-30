<?php

use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Application;
use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\Url as UrlProvider;
use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;



// 注册一个自动加载器
$loader = new Loader();

$loader->registerDirs(
    [
        "../app/controllers/",
        "../app/models/",
    ]
);

$loader->register();



// 创建一个 DI
$di = new FactoryDefault();

// 设置视图组件
$di->set(
    "view",
    function () {
        $view = new View();

        $view->setViewsDir("../app/views/");

        return $view;
    }
);

// 设置一个基础URI, 这样所有生成的URI都包含"tutorial"文件夹
$di->set(
    "url",
    function () {
        $url = new UrlProvider();

        $url->setBaseUri("/financ/");

        return $url;
    }
);



$application = new Application($di);

try {
    // 处理请求
    $response = $application->handle();

    $response->send();
} catch (\Exception $e) {
    echo "Exception: ", $e->getMessage();
}
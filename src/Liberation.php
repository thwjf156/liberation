<?php

namespace Thwjf156\Liberation;

use Illuminate\View\FileViewFinder;
use InvalidArgumentException;

class Liberation
{
    /**
     * callStatic
     *
     * @param $name
     * @param $arguments
     * @return string
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public static function __callStatic($name, $arguments)
    {
        $app = app();
        $view = view();

        if (count($arguments) === 0) {
            throw new InvalidArgumentException();
        }

        $fileName = $arguments[0];
        $params = $arguments[1] ?? [];
        $orgFinder = $view->getFinder();
        $sqlPath = resource_path() . '/' . $name;

        $newFinder = new FileViewFinder($app['files'], [$sqlPath]);
        $view->setFinder($newFinder);
        $view->addExtension($name, 'blade');
        $obj = $view->make($fileName, $params);

        $result = $obj->render();
        $view->setFinder($orgFinder);

        $result = str_replace("\n", " ", $result);
        $result = substr($result, -1) == ';' ? substr($result, 0, -1) : $result;
        if (strpos($result, ';')) {
            $results = explode(';', $result);
            $result = $results[count($results) - 1];
        }
        $result = str_replace("@", ":", $result);

        return trim($result);
    }
}

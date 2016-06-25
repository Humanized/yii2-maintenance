<?php

/**
 * @link https://github.com/humanized/yii2-maintenance
 * @copyright Copyright (c) 2016 Humanized BV Comm V
 * @license https://github.com/humanized/yii2-maintenance/LICENSE
 */

namespace humanized\maintenance\helpers;

class RouteContainer
{

    private $_container = [];

    public function get($controller, $action, $module = NULL)
    {
        if ($module == NULL) {
            $module = '@default';
        }
    }

    public function add($route)
    {
        if (substr($route, 0, 1) == '/') {
            $route = substr($route, 1);
        }
        $this->_add(explode('/', $route));
    }

    private function _add($route)
    {
        $count = count($route);
        $controller = $route[$count - 2];
        $action = $route[$count - 1];
        $module = $count == 3 ? $route[0] : '@default';
    }

    public function _addContainer($controller, $action, $module = '@default')
    {
        if (!isset($this->$_container['module'])) {
            
        }
    }

}

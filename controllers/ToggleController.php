<?php

namespace humanized\maintenance\controllers;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use yii\web\Controller;

class ToggleController extends Controller
{

    /**
     * 
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'index' => 'humanized\maintenance\actions\ToggleAction',
            'enable' => 'humanized\maintenance\actions\EnableAction',
            'disable' => 'humanized\maintenance\actions\DisableAction',
        ];
    }

}

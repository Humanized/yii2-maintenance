<?php

namespace humanized\maintenance\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use humanized\maintenance\models\Maintenance;

class ToggleButton extends ToggleLink
{

    public function init()
    {
        parent::init();

        if (!isset($this->options['class'])) {
            $this->options['class'] = 'btn btn-' . ($this->isEnabled ? 'success' : 'primary');
        }
    }

}

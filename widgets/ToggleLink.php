<?php

namespace humanized\maintenance\widgets;

use yii\base\Widget;
use yii\helpers\Html;
use humanized\maintenance\models\Maintenance;

class ToggleLink extends Widget
{

    public $label;
    public $encodeLabel = true;
    public $options = [];
    public $url = ['/maintenance/toggle'];
    protected $isEnabled = false;

    public function init()
    {
        parent::init();

        $this->isEnabled = Maintenance::isEnabled();

        if (!isset($this->label)) {
            $prefix = $this->isEnabled ? 'Disable' : 'Enable';
            $this->label = $prefix . ' ' . 'Maintenance Mode';
        }

        if (!isset($this->options['data-method'])) {
            $this->options['data-method'] = 'post';
        }
    }

    public function run()
    {
        return Html::a($this->encodeLabel ? Html::encode($this->label) : $this->label, $this->url, $this->options);
    }

}

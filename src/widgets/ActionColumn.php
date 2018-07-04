<?php

namespace indigerd\adminmodule\widgets;

use Yii;
use yii\grid\ActionColumn as BaseActionColumn;

class ActionColumn extends BaseActionColumn
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->initButtonsVisibility();
    }

    protected function initButtonsVisibility()
    {
        foreach ($this->buttons as $button) {
            $this->initButtonVisibility($button);
        }
    }

    protected function initButtonVisibility($name)
    {
        $route = ltrim(implode('/',[
            Yii::$app->controller->module->getUniqueId(),
            Yii::$app->controller->getUniqueId(),
            $name
        ]), '/');
        $this->visibleButtons[$name] = Yii::$app->user->can('administrator') or Yii::$app->user->can($route);
    }
}

<?php

namespace indigerd\adminmodule\widgets;

use yii\grid\ActionColumn as BaseActionColumn;

class ActionColumn extends BaseActionColumn
{
    /** @var array visibility conditions for each button. The array keys are the button names (without curly brackets),
     * and the values are the boolean true/false or the anonymous function. When the button name is not specified in
     * this array it will be shown by default.
     * The callbacks must use the following signature:
     *
     * ```php
     * function ($model, $key, $index) {
     *     return $model->status === 'editable';
     * }
     * ```
     *
     * Or you can pass a boolean value:
     *
     * ```php
     * [
     *     'update' => \Yii::$app->user->can('update'),
     * ],
     * ```
     * @since 2.0.7
     */
    public $visibleButtons = [];

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

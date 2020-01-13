<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

/**
 * @var yii\widgets\ActiveForm $form
 * @var dektrium\user\models\User $user
 * @var app\modules\progress\models\UserProgram $user_program
 */

use app\modules\constructor\models\Programs;
use yii\helpers\ArrayHelper; ?>

<?= $form->field($user, 'email')->textInput(['maxlength' => 255]) ?>
<?= $form->field($user, 'username')->textInput(['maxlength' => 255]) ?>
<?= $form->field($user_program, 'program_id')->dropDownList(ArrayHelper::map(Programs::find()->all(), 'id', 'name'));

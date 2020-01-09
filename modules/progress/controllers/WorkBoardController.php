<?php

namespace app\modules\progress\controllers;

use app\modules\constructor\models\Qvariant;
use app\modules\constructor\models\Tests;
use app\modules\constructor\models\Tquest;
use app\modules\progress\models\User;
use app\modules\progress\models\UserProgram;
use app\modules\progress\models\UserQuestion;
use app\modules\progress\models\UserTest;
use app\modules\progress\models\UserTheme;
use app\modules\progress\models\UserTquest;
use Yii;
use yii\helpers\VarDumper;

class WorkBoardController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $user = User::findOne(['id' => \Yii::$app->user->id]);
//        $programsProgress = [];
//        foreach ($user->userPrograms as $userProgram){
//            $programsProgress[] = [
//                'program' => $userProgram->program,
//                'progress' => [
//                    'program_progress' => $userProgram->progress,
//                    'themes_progress' => [],
//                    ]
//                ];
//            foreach ($userProgram->program->themes as $theme) {
//                $programsProgress['progress']['themes_progress'][] = $theme
//            }
//        }
        return $this->render('index', [
            'program' => $user->userPrograms[0]->program,
        ]);
    }

    public function actionTest($test_id = 1)
    {
        if(Yii::$app->request->post()) {
            foreach (Yii::$app->request->post() as $key=>$answer) {
                if($key == '_csrf')
                    continue;

                $quset_variant_model = Qvariant::findOne(['id' => $answer]);
                $user_tquest_model = UserTquest::find()->where(['user_id' => Yii::$app->user->id])
                    ->andWhere(['tquest_id' => $quset_variant_model->tquest->id])
                    ->one();
                $user_tquest_model->answer_by_user = $answer;
                $user_tquest_model->common_flag = 1;
                $user_tquest_model->save();
            }

            $user_theme_model = UserTheme::find()->where(['user_id' => Yii::$app->user->id])
                ->andWhere(['theme_id' => $user_tquest_model->tquest->test_id])
                ->one();
            VarDumper::dump($user_theme_model,10,true);

        }
        $test = Tests::findOne(['id' => $test_id]);
        return $this->render('test', [
            'test' => $test,
        ]);
    }

    public static function actionProgressGenerate()
    {
        //Создаем прогресс по программе для пользователя
        $user_program = new UserProgram();
        $user_program->user_id = \Yii::$app->user->id;
        $user_program->program_id = 1;
        $user_program->save();
        //Создаем прогресс по каждой теме программы
        foreach ($user_program->program->themes as $theme){

            $user_theme = new UserTheme();
            $user_theme->user_id = \Yii::$app->user->id;
            $user_theme->theme_id = $theme->id;
            $user_theme->save();
            //Создаем прогресс по каждому заданию темы
            foreach ($user_theme->theme->questions as $question){
                $user_question = new UserQuestion();
                $user_question->user_id = \Yii::$app->user->id;
                $user_question->question_id = $question->id;
                $user_question->save();
            }
            //Создаем прогресс по каждому тесту темы
            foreach ($user_theme->theme->tests as $test){

                $user_test = new UserTest();
                $user_test->user_id = \Yii::$app->user->id;
                $user_test->test_id = $test->id;
                $user_test->save();
                //Создаем флажок по каждому ответу на вопрос теста
                foreach ($user_test->test->tquests as $tquest){
                    $user_tquest = new UserTquest();
                    $user_tquest->user_id = \Yii::$app->user->id;
                    $user_tquest->tquest_id = $tquest->id;
                    $user_tquest->save();
                }
            }
        }
    }
}

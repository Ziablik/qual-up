<?php

namespace app\modules\progress\controllers;

use app\modules\constructor\models\Tests;
use app\modules\progress\models\User;
use app\modules\progress\models\UserProgram;
use app\modules\progress\models\UserQuestion;
use app\modules\progress\models\UserTest;
use app\modules\progress\models\UserTheme;
use app\modules\progress\models\UserTquest;
use yii\helpers\VarDumper;

class WorkBoardController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $user = User::findOne(['id' => \Yii::$app->user->id]);
//        VarDumper::dump($user->userPrograms[0],10,true);
        $programsProgress = [];
        foreach ($user->userPrograms as $userProgram){
//            VarDumper::dump($userProgram->program,10,true);
            $programsProgress[] = [
                'program' => $userProgram->program,
                'progress' => [
                    'program_progress' => $userProgram,

                    ]
                ];
        }
        return $this->render('index', [
            'program' => $user->userPrograms[0]->program,
        ]);
    }

    public function actionTest($id = 1)
    {
        $test = Tests::findOne(['id' => $id]);
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

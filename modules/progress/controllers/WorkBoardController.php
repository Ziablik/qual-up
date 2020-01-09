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
use yii\base\ErrorException;
use yii\helpers\VarDumper;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

class WorkBoardController extends \yii\web\Controller
{
    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

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
        $test = Tests::findOne(['id' => $test_id]);
        $user_test_model = UserTest::find()
            ->where(['user_id' => Yii::$app->user->id])
            ->andWhere(['test_id' => $test_id])
            ->one();

//        if ($user_test_model->test_points != null)
//            throw new ForbiddenHttpException( 'Вы уже проходили данный тест', 403);

        if(Yii::$app->request->post()) {
            foreach (Yii::$app->request->post() as $key=>$answer) {

                if($key == '_csrf') {
                    unset(Yii::$app->request->post()['_csrf']);
                    continue;
                }

                $quest_variant_model = Qvariant::findOne(['id' => $answer]);
                $user_tquest_model = UserTquest::find()->where(['user_id' => Yii::$app->user->id])
                    ->andWhere(['tquest_id' => $quest_variant_model->tquest->id])
                    ->one();
                $user_tquest_model->common_answer_by_user = $answer;
//                $user_tquest_model->save();
            }

            $user_test_model = UserTest::find()
                ->where(['user_id' => Yii::$app->user->id])
                ->andWhere(['test_id' => $test_id])
                ->one();
            $answers_by_user = $user_test_model->calculateCommonTest($test_id, Yii::$app->request->post());

            $user_theme_model = UserTheme::find()->where(['user_id' => Yii::$app->user->id])
                ->andWhere(['theme_id' => $test_id])
                ->one();
            $user_theme_model->progress += 40;
//            $user_theme_model->save();

            return $this->render('test-check', [
                'test' => $test,
                'answers_by_user' => $answers_by_user
            ]);
        }

        return $this->render('test', [
            'test' => $test,
        ]);
    }

    //Нажатие кнопки выполнения заданий к теме
    public function actionQuestionOn(){
        if (Yii::$app->request->post()) {
            $user_question_model = UserQuestion::find()
                ->where(['user_id' => Yii::$app->user->id])
                ->andWhere(['question_id' => Yii::$app->request->post('question_id')])
                ->one();
            $user_question_model->completed = 1;
            $user_question_model->save();

            $user_theme_model = UserTheme::find()
                ->where(['user_id' => Yii::$app->user->id])
                ->andWhere(['theme_id' => $user_question_model->question->theme_id])
                ->one();

            $user_theme_model->progress += 30/count($user_theme_model->theme->questions);
            $user_theme_model->save();
            return json_encode(['progress' => $user_theme_model->progress, 'theme_id' => $user_theme_model->theme_id]);
        }
        return new \Exception('Пустой POST');
    }

    public function actionPresentationSuccess(){
        if (Yii::$app->request->post()) {
            $user_theme_model = UserTheme::find()
                ->where(['user_id' => Yii::$app->user->id])
                ->andWhere(['theme_id' => Yii::$app->request->post('theme_id')])
                ->one();
            if ($user_theme_model->presentation_success == 0){
                $user_theme_model->presentation_success = 1;
                $user_theme_model->progress += 30;
                $user_theme_model->save();
            }

            return json_encode(['progress' => $user_theme_model->progress, 'theme_id' => $user_theme_model->theme_id]);
        }
        return true;
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

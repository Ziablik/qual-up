<?php

namespace app\modules\progress\controllers;

use app\modules\constructor\models\Programs;
use app\modules\constructor\models\Qvariant;
use app\modules\constructor\models\Tests;
use app\modules\constructor\models\Themes;
use app\modules\constructor\models\Tquest;
use app\modules\progress\models\User;
use app\modules\progress\models\UserProgram;
use app\modules\progress\models\UserQuestion;
use app\modules\progress\models\UserTest;
use app\modules\progress\models\UserTheme;
use app\modules\progress\models\UserTquest;
use Yii;
use yii\base\ErrorException;
use yii\base\Theme;
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

        if ($user_test_model->test_points != null)
            throw new ForbiddenHttpException( 'Вы уже проходили данный тест', 403);

        if(Yii::$app->request->post()) {
            foreach (Yii::$app->request->post() as $key=>$answer) {

                if($key == '_csrf') {
                    continue;
                }

                $quest_variant_model = Qvariant::findOne(['id' => $answer]);
                $user_tquest_model = UserTquest::find()->where(['user_id' => Yii::$app->user->id])
                    ->andWhere(['tquest_id' => $quest_variant_model->tquest->id])
                    ->one();
                $user_tquest_model->common_answer_by_user = $answer;
                $user_tquest_model->save();
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
            $user_theme_model->save();

            $user_program_model = UserProgram::find()
                ->where(['user_id' => Yii::$app->user->id])
                ->andWhere(['program_id' => $test->theme->program->id])
                ->one();
            $user_program_model->calculateProgress();

            return $this->render('test-check', [
                'test' => $test,
                'answers_by_user' => $answers_by_user
            ]);
        }

        return $this->render('test', [
            'test' => $test,
        ]);
    }

    public function actionFinishTest($program_id = null){
        $user_program_model = UserProgram::find()
            ->where(['user_id' => Yii::$app->user->id])
            ->andWhere(['program_id' => $program_id])
            ->one();

        $user_test_model = UserTest::find()
            ->where(['user_id' => Yii::$app->user->id])
            ->andWhere(['test_type' => 'finish_test'])
            ->one();

        if ($user_program_model->finish_test_is_complete == 1)
            throw new ForbiddenHttpException( 'Вы уже прошли данный тест', 403);
        elseif ($user_test_model->count_attempts == 2)
            throw new ForbiddenHttpException( 'У вас закончились попытки, пожалуйста обратитесь в поддержку', 403);


        $program_model = Programs::findOne(['id' => $program_id]);
        $finish_test = [];
        foreach ($program_model->themes as $theme){
            foreach ($theme->tests[0]->tquests as $tquest){
                array_push($finish_test, $tquest);
            }
        }
        shuffle($finish_test);

        if(Yii::$app->request->post()) {
            foreach (Yii::$app->request->post() as $key=>$answer) {

                if($key == '_csrf') {
                    continue;
                }

                $quest_variant_model = Qvariant::findOne(['id' => $answer]);
                $user_tquest_model = UserTquest::find()->where(['user_id' => Yii::$app->user->id])
                    ->andWhere(['tquest_id' => $quest_variant_model->tquest->id])
                    ->one();
                $user_tquest_model->finish_answer_by_user = $answer;
                $user_tquest_model->save();
            }

            $answers_by_user = $user_test_model->calculateFinishTest($finish_test ,Yii::$app->request->post());

            if ($user_test_model->test_points/$user_test_model->count_quests >= 0.7){
                $user_program_model->finish_test_is_complete = 1;
                $user_program_model->save();
            }

            return $this->render('test-result', [
                'answers_by_user' => $answers_by_user,
                'user_test_model' => $user_test_model
            ]);
        }

        return $this->render('finish-test', [
            'test' => $finish_test,
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

            $theme_model = Themes::findOne(['id' => $user_theme_model->theme_id]);
            $user_program_model = UserProgram::find()
                ->where(['user_id' => Yii::$app->user->id])
                ->andWhere(['program_id' => $theme_model->program->id])
                ->one();
            $user_program_model->calculateProgress();

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

                $theme_model = Themes::findOne(['id' => $user_theme_model->theme_id]);
                $user_program_model = UserProgram::find()
                    ->where(['user_id' => Yii::$app->user->id])
                    ->andWhere(['program_id' => $theme_model->program->id])
                    ->one();
                $user_program_model->calculateProgress();
            }

            return json_encode(['progress' => $user_theme_model->progress, 'theme_id' => $user_theme_model->theme_id]);
        }
        return true;
    }

    public static function actionProgressGenerate($user_id, $user_program)
    {
        //Создаем прогресс по программе для пользователя
        $user_finish_test = new UserTest();
        $user_finish_test->user_id = $user_id;
        $user_finish_test->test_type = 'finish_test';
        $user_finish_test->count_quests = 0;

        //Создаем прогресс по каждой теме программы
        foreach ($user_program->program->themes as $theme){

            $user_theme = new UserTheme();
            $user_theme->user_id = $user_id;
            $user_theme->theme_id = $theme->id;
            $user_theme->save();
            //Создаем прогресс по каждому заданию темы
            foreach ($user_theme->theme->questions as $question){
                $user_question = new UserQuestion();
                $user_question->user_id = $user_id;
                $user_question->question_id = $question->id;
                $user_question->save();
            }
            //Создаем прогресс по каждому тесту темы
            foreach ($user_theme->theme->tests as $test){

                $user_test = new UserTest();
                $user_test->user_id = $user_id;
                $user_test->test_id = $test->id;
                $user_test->test_type = 'common_test';
                $user_test->count_quests = 0;
                //Создаем флажок по каждому ответу на вопрос теста
                foreach ($user_test->test->tquests as $tquest){

                    $user_test->count_quests += 1;
                    $user_finish_test->count_quests += 1;

                    $user_tquest = new UserTquest();
                    $user_tquest->user_id = $user_id;
                    $user_tquest->tquest_id = $tquest->id;
                    $user_tquest->save();
                }

                $user_test->save();
            }
        }

        $user_finish_test->save();
    }
}

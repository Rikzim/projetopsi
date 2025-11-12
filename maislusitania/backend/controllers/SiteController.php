<?php

namespace backend\controllers;

use common\models\LoginForm;
use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            // Verifica se o utilizador tem permissão para aceder ao backoffice
                            return Yii::$app->user->can('accessBackoffice');
                        },
                        'denyCallback' => function ($rule, $action) {
                            // Redireciona para o frontend se não tiver permissão
                            Yii::$app->session->setFlash('error', 'Não tem permissão para aceder ao back-office.');
                            return Yii::$app->response->redirect(['/site/login']);
                        },
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        if (!Yii::$app->user->can('accessBackoffice')) {
            return $this->redirect(['site/login']);
        }
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return string|Response
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            // Verifica se tem permissão para estar no backend
            if (!Yii::$app->user->can('accessBackoffice')) {
                Yii::$app->session->setFlash('error', 'Não tem permissão para aceder ao back-office.');
                Yii::$app->user->logout();
                return $this->refresh();
            }
            return $this->goHome();
        }

        $this->layout = 'blank';

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            // Após login, verifica se tem permissão
            if (!Yii::$app->user->can('accessBackoffice')) {
                Yii::$app->session->setFlash('error', 'Não tem permissão para aceder ao back-office. Apenas gestores e administradores.');
                Yii::$app->user->logout();
                $model->password = '';
                return $this->render('login', ['model' => $model]);
            }
            return $this->goBack();
        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}

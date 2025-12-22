<?php

namespace backend\controllers;

use common\models\LoginForm;
use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use common\models\User;
use common\models\Noticia;
use common\models\LocalCultural;
use common\models\Evento;
use common\models\Reserva;
use common\models\Avaliacao;
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
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['accessBackoffice'],
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
        
        $locaisCount = LocalCultural::find()->count();
        $eventosCount = Evento::find()->count();
        $noticiasCount = Noticia::find()->count();
        $usersCount = User::find()->count();

        $reservasMesCount = Reserva::find()
            ->where(['between', 'data_visita', date('Y-m-01'), date('Y-m-t')])
            ->count();

        $ultimasReservas = Reserva::find()
            ->orderBy(['data_visita' => SORT_DESC])
            ->limit(5)
            ->all();

        $ultimasAvaliacoes = Avaliacao::find()
            ->orderBy(['data_avaliacao' => SORT_DESC])
            ->limit(5)
            ->all();

        $salesData = [];
        $labels = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = date('Y-m', strtotime("-$i months"));
            $start = $month . '-01';
            $end = date('Y-m-t', strtotime($start));
            $labels[] = Yii::$app->formatter->asDate($start, 'MMMM'); // e.g., 'Maio'
            $salesData[] = (float)Reserva::find()
                ->where(['between', 'data_visita', $start, $end])
                ->sum('preco_total') ?: 0;
}
        
        return $this->render('index', [
            'locaisCount' => $locaisCount,
            'eventosCount' => $eventosCount,
            'noticiasCount' => $noticiasCount,
            'usersCount' => $usersCount,
            'reservasMesCount' => $reservasMesCount,
            'ultimasReservas' => $ultimasReservas,
            'ultimasAvaliacoes' => $ultimasAvaliacoes,
            'salesData' => $salesData,
            'salesLabels' => $labels,
        ]);
    }

    /**
     * Login action.
     *
     * @return string|Response
     */
    public function actionLogin()
    {
        $this->layout = 'blank';

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            // Após login, verifica se tem permissão
            if (!Yii::$app->user->can('accessBackoffice')) {
                Yii::$app->user->logout();
                $model->password = '';
                return $this->render('login', [
                    'model' => $model,
                    'error' => 'Não tem permissão para aceder ao back-office. Apenas gestores e administradores.',
                ]);
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

<?php

namespace frontend\controllers;

use common\models\Evento;
use common\models\TipoLocal;
use frontend\models\EventoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;

class EventoController extends Controller
{
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    public function actionIndex()
    {
        $searchModel = new EventoSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        $dataProvider->query->joinWith(['local.tipoLocal', 'local.distrito']);

        $dataProvider->pagination->pageSize = 10;

        // Filter by tipo if provided
        $tipo = Yii::$app->request->get('tipo');
        if ($tipo) {
            $dataProvider->query->andWhere(['local_cultural.tipo_id' => $tipo]);
        }

        $tiposLocal = TipoLocal::find()
            ->select(['tipo_local.id', 'tipo_local.nome', 'COUNT(evento.id) as total'])
            ->leftJoin('local_cultural', 'local_cultural.tipo_id = tipo_local.id')
            ->leftJoin('evento', 'evento.local_id = local_cultural.id AND evento.ativo = 1')
            ->groupBy(['tipo_local.id', 'tipo_local.nome'])
            ->asArray()
            ->all();

        $totalEventos = Evento::find()->where(['ativo' => 1])->count();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'tiposLocal' => $tiposLocal,
            'totalEventos' => $totalEventos,
        ]);
    }


    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    protected function findModel($id)
    {
        if (($model = Evento::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

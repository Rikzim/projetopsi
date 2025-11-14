<?php

namespace frontend\controllers;

use common\models\Noticia;
use common\models\TipoLocal;
use frontend\models\NoticiaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class NoticiaController extends Controller
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
        $searchModel = new NoticiaSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $destaqueNoticia = Noticia::find()
            ->where(['destaque' => 1, 'ativo' => 1])
            ->orderBy(['data_publicacao' => SORT_DESC])
            ->one();
        $tiposLocal = TipoLocal::find()
            ->select(['tipo_local.id', 'tipo_local.nome', 'COUNT(noticia.id) as total'])
            ->leftJoin('local_cultural', 'local_cultural.tipo_id = tipo_local.id')
            ->leftJoin('noticia', 'noticia.local_id = local_cultural.id AND noticia.ativo = 1')
            ->groupBy(['tipo_local.id', 'tipo_local.nome'])
            ->asArray()
            ->all();
        $totalNoticias = Noticia::find()->where(['ativo' => 1])->count();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'destaqueNoticia' => $destaqueNoticia,
            'tiposLocal' => $tiposLocal,
            'totalNoticias' => $totalNoticias,
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
        if (($model = Noticia::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

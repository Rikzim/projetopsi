<?php

namespace frontend\controllers;

use common\models\LocalCultural;
use common\models\TipoLocal;
use common\models\Distrito;

use frontend\models\LocalCulturalSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * LocalCulturalController implements the CRUD actions for LocalCultural model.
 */
class LocalCulturalController extends Controller
{
    /**
     * @inheritDoc
     */
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

    /**
     * Lists all LocalCultural models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new LocalCulturalSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        // Buscar tipos de local para dropdown
        $tiposLocal = ArrayHelper::map(
            TipoLocal::find()->orderBy('nome')->all(),
            'id',
            'nome'
        );

        // Buscar distritos para dropdown
        $distritos = ArrayHelper::map(
            Distrito::find()->orderBy('nome')->all(),
            'id',
            'nome'
        );

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'tiposLocal' => $tiposLocal,
            'distritos' => $distritos,
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
        if (($model = LocalCultural::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

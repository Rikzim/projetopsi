<?php

namespace frontend\controllers;

use Yii;

use common\models\Favorito;
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
        $model = $this->findModel($id);
        $averageRating = $this->findModel($id)->getAverageRating();
        $ratingCount = $this->findModel($id)->getRatingCount();
        $horario = $this->findModel($id)->getHorarios()->one();
        $eventos = $this->findModel($id)->getEventos()->all();
        $noticias = $this->findModel($id)->getNoticias()->all();
        $bilhetes = $this->findModel($id)->getTipoBilhetes()->all();

        return $this->render('view', [
            'model' => $model,
            'averageRating' => $averageRating,
            'ratingCount' => $ratingCount,
            'horario' => $horario,
            'eventos' => $eventos,
            'noticias' => $noticias,
            'bilhetes' => $bilhetes,

        ]);
    }

    public function actionToggleFavorite($id)
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }

        $local = $this->findModel($id);
        $user = Yii::$app->user->identity;

        // Verificar se já existe
        $index = array_search($id, array_column($user->favorites, 'local_id'));
        if ($index) {
            $favorito = $user->favorites[$index]->delete();
            Yii::$app->session->setFlash('success', 'Removido dos favoritos!');
        } else {
            // Se não existe, adicionar
            $favorito = new Favorito();
            $favorito->utilizador_id = $user->id;
            $favorito->local_id = $id;
            $favorito->data_adicao = date('Y-m-d H:i:s');
            
            $favorito->save();
        }

        if (Yii::$app->request->isPjax) {
            return $this->actionIndex();
        }

        return $this->redirect(Yii::$app->request->referrer ?: ['index']);
    }
    protected function findModel($id)
    {
        if (($model = LocalCultural::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

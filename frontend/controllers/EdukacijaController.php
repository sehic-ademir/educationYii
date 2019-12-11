<?php

namespace frontend\controllers;

use Yii;
use common\models\Edukacije;
use frontend\models\EdukacijaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\Prijavljeni;
use DateTime;

/**
 * EdukacijaController implements the CRUD actions for Edukacije model.
 */
class EdukacijaController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Edukacije models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();

        }
        if (Yii::$app->user->identity->approved != true) {
            return $this->goHome();

        }

        $searchModel = new EdukacijaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Edukacije model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();

        }
        if (Yii::$app->user->identity->approved != true) {
            return $this->goHome();

        }

        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    

    /**
     * Finds the Edukacije model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Edukacije the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();

        }
        if (Yii::$app->user->identity->approved != true) {
            return $this->goHome();

        }

        if (($model = Edukacije::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    public function actionChangeState($id) {
    if (Yii::$app->user->isGuest) {
            return $this->goHome();

        }
        if (Yii::$app->user->identity->approved != true) {
            return $this->goHome();

        }
        $time = date('Y-m-d H:i:s');
     
        if(Prijavljeni::find()->where(['user_id' => Yii::$app->user->identity->id, 'lecture_id' => $id])->one() == false) {
        
        $prijavljeni = new Prijavljeni();
        $prijavljeni->user_id = Yii::$app->user->identity->id;
        $prijavljeni->lecture_id = $id;
        $prijavljeni->created_at = $time;
        }
        else 
            $prijavljeni = Prijavljeni::find()->where(['user_id' => Yii::$app->user->identity->id, 'lecture_id' => $id])->one();

           
        if($prijavljeni->status == false) {
        $prijavljeni->status = 1;
        $prijavljeni->updated_at = $time;    
    }
       else {
        $prijavljeni->status = 0;
        $prijavljeni->updated_at = $time;    
    }
       
         $prijavljeni->save();
         
    }
}

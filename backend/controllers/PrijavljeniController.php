<?php

namespace backend\controllers;

use Yii;
use common\models\Prijavljeni;
use backend\models\PrijavljeniSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\Edukacije;

/**
 * PrijavljeniController implements the CRUD actions for Prijavljeni model.
 */
class PrijavljeniController extends Controller
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
     * Lists all Prijavljeni models.
     * @return mixed
     */
    public function actionIndex($id)
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();

        }
        $edukacija = Edukacije::findOne($id)->lecture_title;
       
        $searchModel = new PrijavljeniSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        return $this->render('index', [
            'naziv' => $edukacija,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
      
    }

    /**
     * Displays a single Prijavljeni model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();

        }
        return $this->render('view', [
            'model' => $this->findPrijavljeniModel($id),
        ]);
    }

    /**
     * Creates a new Prijavljeni model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();

        }
        $model = new Prijavljeni();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Prijavljeni model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();

        }

        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/edukacije/prijavljeni', 'id' => $model->lecture_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Prijavljeni model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();

        }
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Prijavljeni model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Prijavljeni the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();

        }
        if (($model = Prijavljeni::findOne(['lecture_id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    protected function findPrijavljeniModel($id)
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();

        }
        if (($model = Prijavljeni::find()
        ->where(['lecture_id' => $id])
      
        ->all()) !== null) {
            return $model;
        }
   
      
    }
    
    public function actionChangeState($id) {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();

        }
        $prijavljeni = Prijavljeni::findOne($id);   
        if($prijavljeni->present == false)
        $prijavljeni->present = 1;
        else 
        $prijavljeni->present = 0;
    
        $prijavljeni->save();
    }
    

}

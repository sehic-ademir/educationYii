<?php

namespace backend\controllers;

use Yii;
use common\models\Edukacije;
use common\models\Prijavljeni;
use backend\models\EdukacijeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use backend\models\UploadEduFiles;
use backend\models\PrijavljeniSearch;
use common\models\User;
/**
 * EdukacijeController implements the CRUD actions for Edukacije model.
 */
class EdukacijeController extends Controller
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
        $searchModel = new EdukacijeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionUploadfile()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();

        }
        $edukacijaId=Yii::$app->request->get('id');
        
        $model = new UploadEduFiles();
        
        if (Yii::$app->request->isPost) {
            $edukacijaId = Yii::$app->request->post('edukacijaId');
            $model->file = UploadedFile::getInstances($model, 'file');
            if ($model->uploadFile($edukacijaId)) {
                Yii::$app->session->setFlash('success', 'Uploadovali ste edukaciju.');
                
                return $this->redirect(['index']);
            }
        }
        return $this->render('uploadfile', ['model' => $model, 'edukacijaId' => $edukacijaId]);
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
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Edukacije model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();

        }
        $model = new Edukacije();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['uploadfile', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    
    /**
     * Updates an existing Edukacije model.
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
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Edukacije model.
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
        if (($model = Edukacije::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    protected function findUserModel($id)
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();

        }
        if (($model = Prijavljeni::find()->where(['user_id' => $id])->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    public function actionPrijavljeni($id)
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();

        }
        
        $userId = Yii::$app->request->post('profileId');

      
      
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model = $this->findUserModel($userId);
            $model->prisutan = ($model->prisutan ) ? 0 : 1;
            $model->save();
        }
        $model = $this->findPrijavljeniModel($id);
        return $this->render('prijavljeni', [
            'model' => $model,
        ]);
       
       
    }
    protected function findPrijavljeniModel($id)
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();

        }
        if (($model = Prijavljeni::find()
        ->where(['edukacije_id' => $id])
      
        ->all()) !== null) {
            return $model;
        }
        $model = $this->findUserModel($id);
      
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

}

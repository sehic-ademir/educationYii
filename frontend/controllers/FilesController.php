<?php

namespace frontend\controllers;

use Yii;
use common\models\Files;
use frontend\models\FilesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\Edukacije;
use frontend\models\UploadHomework;
use yii\web\UploadedFile;
/**
 * FilesController implements the CRUD actions for Files model.
 */
class FilesController extends Controller
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
     * Lists all Files models.
     * @return mixed
     */
    public function actionIndex($id)
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();

        }
        if (Yii::$app->user->identity->approved != true) {
            return $this->goHome();

        }
        if(Edukacije::findOne($id)){
        $edukacija = Edukacije::findOne($id)->lecture_title;
        $filepath = '/edukacije/';
        
        $searchModel = new FilesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        return $this->render('index', [
            'filepath' => $filepath,
            'naziv' => $edukacija,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
        }
        else {
            Yii::$app->session->setFlash('danger', 'Edukacija ne postoji.');
            return $this->redirect('/edukacije');
        }
    }
    public function actionUpload()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();

        }
        $edukacijaId=Yii::$app->request->get('id');
        
        $edukacija = Edukacije::find()->where(['id' => $edukacijaId])->limit('1')->one();

        $model = new UploadHomework();
        
        if (Yii::$app->request->isPost) {
            $edukacijaId = Yii::$app->request->post('edukacijaId');
            $model->file = UploadedFile::getInstance($model, 'file');
            if ($model->uploadFile($edukacijaId)) {
                Yii::$app->session->setFlash('success', 'Uploadovali ste zadacu.');
                
                return $this->redirect(['/edukacija/view', 'id' => $edukacijaId]);
            }
        }
        return $this->render('upload', ['model' => $model, 'edukacijaId' => $edukacijaId, 'naziv' => $edukacija->lecture_title]);
    }

    /**
     * Displays a single Files model.
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
     * Creates a new Files model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */


    /**
     * Updates an existing Files model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */


    /**
     * Deletes an existing Files model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
    */

    /**
     * Finds the Files model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Files the loaded model
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
        if (($model = Files::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}

<?php

namespace backend\controllers;

use Yii;
use common\models\Files;
use backend\models\FilesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\Edukacije;
use common\models\UserFiles;
use backend\models\UserFilesSearch;
use backend\models\UserFileSearch;
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
        if(Edukacije::findOne($id)){
        $edukacija = Edukacije::findOne($id)->lecture_title;
        $filepath = Yii::$app->urlManagerFrontEnd->createAbsoluteUrl('edukacije/');
        
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
        $edukacija = Edukacije::findOne($id)->lecture_title;
        $searchModel = new UserFilesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('view', [
            'naziv' => $edukacija,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionHomeworks($id) {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();

        }
        $searchModel = new UserFileSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('homeworks', [
            'user_id' => $id,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Files model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();

        }
        $model = new Files();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
           
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Files model.
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
     * Deletes an existing Files model.
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
        if (($model = Files::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    protected function findUserFileModel($id)
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();

        }
        if (($model = $model = UserFiles::find()
        ->where(['user_id' => Yii::$app->user->identity->id, 'edukacije_id' => $id])->all()
        ) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}



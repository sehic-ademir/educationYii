<?php

namespace backend\controllers;

use Yii;
use common\models\User;
use backend\models\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\Prijavljeni;
use common\models\Edukacije;
use common\models\UserSkill;
/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
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
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();

        }
        
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();

        }
        $brojEdukacija = Edukacije::find()->all();
        $brojEdukacija = count($brojEdukacija);
        $brojPrisustava = Prijavljeni::find()
        ->where(['user_id' => $id, 'present' => true])
        ->all();
        $brojPrisustava = count($brojPrisustava);
        $userSkills = UserSkill::find()->where(['user_id' => $id, 'status' => true])->all();
        $userSkill = '';
        foreach($userSkills as $singleUserSkill) {
            $userSkill = $userSkill . ' ' . $singleUserSkill->skill_name;
         
        }
        return $this->render('view', [
            'userSkill' => $userSkill,
            'model' => $this->findModel($id),
            'attendance' => $brojPrisustava,
            'totalLectures' => $brojEdukacija,
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();

        }
        $model = new User();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing User model.
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
            return $this->redirect(['view', 'id' => $model->id]) && $this->sendEmail($model);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }
    public function sendEmail($user)
    {
        $ifAccepted = $user->approved;
        $user = $user->email;
        if($ifAccepted){
        return Yii::$app
            ->mailer
            ->compose(
                ['user' => $user]
            )
            ->setTextBody('Your account has been approved by an Admin, you can now access Lectures. Good Luck!')
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' noreply'])
            ->setTo($user)
            ->setSubject('Your account has been approved ' . Yii::$app->name)
            ->send();
    }
    else return;
    }
    /**
     * Deletes an existing User model.
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
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();

        }
        
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

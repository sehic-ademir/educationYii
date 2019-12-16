<?php
namespace frontend\controllers;

use frontend\models\ResendVerificationEmailForm;
use frontend\models\VerifyEmailForm;
use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\UploadedFile;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use frontend\models\UploadForm;
use frontend\models\UploadAvatar;
use common\models\User;
use frontend\models\HomeworkSearch;
use common\models\Prijavljeni;
use common\models\Edukacije;
use common\models\UserSkill;
use frontend\models\NewAdmin;
use backend\models\Admin;
/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout', 'cvupload', 'about', 'contact', 'edukacija'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }
    public function actionMakeadmin()
    {
        $model = new NewAdmin();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', 'You have set up first admin.');
            return $this->goHome();
        }
        if((!Admin::find()->all())){
        return $this->render('makeadmin', [
            'model' => $model,
        ]);
        }
        else return $this->redirect('account');
    }
    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        if(!Yii::$app->user->isGuest) {
            return $this->redirect('/site/account');
        }
        return $this->render('index');
    }
        /**
     * Displays cv upload form.
     *
     * @return mixed
     */
    public function actionCvupload()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();

        }

        $model = new UploadForm();
        
        if (Yii::$app->request->isPost) {
            $model->file = UploadedFile::getInstance($model, 'file');
           
            if ($model->upload()) {
                Yii::$app->session->setFlash('success', 'You uploaded your CV successfuly.');
                
                return $this->redirect('account');
            }
        }
        return $this->render('cvupload', ['model' => $model]);
    }

      
    public function actionUploadavatar() {
     
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new UploadAvatar();
        if (Yii::$app->request->isPost) {
            $model->photo_path = UploadedFile::getInstance($model, 'photo_path');
           
            if ($model->uploadFile()) {
                Yii::$app->session->setFlash('success', 'You uploaded your profile photo successfuly.');
                
                return $this->redirect('account');
            }
        }
        return $this->render('uploadavatar', ['model' => $model]);
    }




    public function actionAccount()
    {    
          if (Yii::$app->user->isGuest) {
        return $this->goHome();
          }
   
    else {
        $id = Yii::$app->user->identity->id;
        $attendance = Prijavljeni::find()
        ->where(['user_id' => Yii::$app->user->identity->id, 'present' => true])
        ->all();
        $attendance = count($attendance);
        $totalLectures = Edukacije::find()->all();
        $totalLectures = count($totalLectures);
        if($totalLectures > 0)
        $percentage = $attendance / $totalLectures * 100;
        else $percentage = 100;
        $percentage = round($percentage);
        $userModel = $this->findModel($id);
        if($userModel->gender)
        $png = '/avatars/defaultmale.png';
        else 
        $png = '/avatars/defaultfemale.png';
        $skills = UserSkill::find()
        ->where(['user_id' => Yii::$app->user->identity->id, 'status' => true])
        ->all();
        
       
        $model = new UploadAvatar();
        if (Yii::$app->request->isPost) {
            $model->photo_path = UploadedFile::getInstance($model, 'photo_path');
           
            if ($model->uploadFile()) {
                Yii::$app->session->setFlash('success', 'You uploaded your profile photo successfuly.');
                
                return $this->redirect('account');
            }
        }
    return $this->render('account', [
        'skills' => $skills,
        'attendance' => $percentage,
        'user' => $userModel,
        'image' => $model,
        'png' => $png
    ]);
    }
    }
    public function actionSettings() {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();

        }
        
        $image = new UploadAvatar();
        if (Yii::$app->request->isPost) {
            $image->photo = UploadedFile::getInstance($image, 'photo');
           
            if ($image->uploadFile()) {
                Yii::$app->session->setFlash('success', 'You uploaded your profile photo successfuly.');
                
                return $this->redirect('account');
            }
        }
        $userModel = $this->findModel(Yii::$app->user->identity->id);
        if($userModel->gender)
        $png = '/avatars/defaultmale.png';
        else 
        $png = '/avatars/defaultfemale.png';
        return $this->render('settings', [
            'png' => $png,
            'image' => $image,
            'model' => $userModel,
        ]);
    }
  
    public function actionUpdate()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();

        }


       
        $model = $this->findModel(Yii::$app->user->identity->id);

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/site/account']);
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionUploads() {
            if (Yii::$app->user->isGuest) {
                return $this->goHome();
            }
    }
    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        else
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {    
          if (Yii::$app->user->isGuest) {
        return $this->goHome();
    }
   
    else {
        $id = Yii::$app->user->identity->id;
    return $this->redirect('account');
    }
   }

     
  
    
    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', 'Thank you for registration. Please check your inbox for verification email.');
            return $this->goHome();
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }


    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * Verify email address
     *
     * @param string $token
     * @throws BadRequestHttpException
     * @return yii\web\Response
     */
    public function actionVerifyEmail($token)
    {
        try {
            $model = new VerifyEmailForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if ($user = $model->verifyEmail()) {
            if (Yii::$app->user->login($user)) {
                Yii::$app->session->setFlash('success', 'Your email has been confirmed!');
                return $this->goHome();
            }
        }

        Yii::$app->session->setFlash('error', 'Sorry, we are unable to verify your account with provided token.');
        return $this->goHome();
    }

    /**
     * Resend verification email
     *
     * @return mixed
     */
    public function actionResendVerificationEmail()
    {
        $model = new ResendVerificationEmailForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
                return $this->goHome();
            }
            Yii::$app->session->setFlash('error', 'Sorry, we are unable to resend verification email for the provided email address.');
        }

        return $this->render('resendVerificationEmail', [
            'model' => $model
        ]);
    }
    public function actionPdf($id) {
        $filename = Yii::$app->user->identity->username;
        $url = Yii::getAlias('@webroot') . "/uploads/" . $id;
    
        return Yii::$app->response->sendFile($url);
    }
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

   public function actionHomeworks() {
    if (Yii::$app->user->isGuest) {
        return $this->goHome();

    }
    if (Yii::$app->user->identity->approved != true) {
        return $this->goHome();

    }    
        $searchModel = new HomeworkSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('homeworks', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }   

 

public function actionAddSkill() {
    $id = Yii::$app->request->post('key');
    if (Yii::$app->user->isGuest) {
            return $this->goHome();

        }
   
       
        $isExisting = false;
        $userId = Yii::$app->user->identity->id;
        $allSkills = UserSkill::find()
        ->where(['user_id' => $userId])->all();
        $skillId = 0;
        foreach($allSkills as $skill) {
          if(strtolower($skill->skill_name) == strtolower($id)){
            $skillId = $skill->id;
            $isExisting = true;
            break;
            }
            else $skillId = 224;
       
        }
        if ($isExisting == false) {
        $addSkill = new UserSkill();
        $addSkill->user_id = $userId;
        $addSkill->skill_name = $id;
        $addSkill->status = 1;
        }
        else {
            $addSkill = UserSkill::find()->where(['id' => $skillId])->one();
            $addSkill->status = 1;
            $addSkill->updated_at = date('Y-m-d H:i:s');
        }
        $addSkill->save();

    }
    

public function actionDeleteSkill($id) {
    if (Yii::$app->user->isGuest) {
            return $this->goHome();

        }
      
        $deleteSkill = UserSkill::find()->where(['id' => $id])->one();
        $deleteSkill->status = 0;
        $deleteSkill->updated_at = date('Y-m-d H:i:s');
        $deleteSkill->save();
         
    }

}
<?php

namespace frontend\controllers;

use Yii;
use frontend\models\message;
use frontend\models\messageSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MessageController implements the CRUD actions for message model.
 */
class MessageController extends Controller
{
    public $user_id;
    public function init(){
        parent::init();
        if(Yii::$app->user->isGuest){
            //未登录
            Yii::$app->getSession()->setFlash('error', '请先登录');
            return $this->redirect(['/site/login']);        
        }else{
            $this->user_id = Yii::$app->user->identity->id;
        }
    }
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
     * Lists all message models.
     * @return mixed
     */
    public function actionIndex()
    {
        $_GET["messageSearch"]["user_id"] = $this->user_id;
        $searchModel = new messageSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single message model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $admin  = \backend\models\User::find()->select("username")->andWhere(['id' => $model->admin_id])->one(); 
        if($admin){
            $adminname = $admin->username;
        }else{
            $adminname = "---";
        }        
        return $this->render('view', [
            'model'     => $model,
            'adminname' => $adminname,
        ]);
    }

    /**
     * Creates a new message model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        Yii::$app->language = 'zh-CN';
        $model = new message();
        if ($model->load(Yii::$app->request->post())) {
            $model->user_id  = $this->user_id;
            $model->add_time = time();
            $model->status   = 0;
            $model->save();
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);

    }

    /**
     * Updates an existing message model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing message model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    /**
     * Finds the message model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return message the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = message::findOne($id)) !== null) {
            if($model->user_id != $this->user_id){
                throw new NotFoundHttpException('异常操作');
            }            
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
   
}

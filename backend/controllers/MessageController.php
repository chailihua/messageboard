<?php

namespace backend\controllers;

use Yii;
use backend\models\Message;
use backend\models\MessageSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\User;

/**
 * MessageController implements the CRUD actions for Message model.
 */
class MessageController extends Controller
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
     * Lists all Message models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MessageSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Message model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $user  = \backend\models\User::find()->select("username")->andWhere(['id' => $model->user_id])->one(); 
        $admin = \backend\models\User::find()->select("username")->andWhere(['id' => $model->admin_id])->one(); 
        if($user){
            $username = $user->username;
        }else{
            $username = "---";
        }
        if($admin){
            $adminname = $admin->username;
        }else{
            $adminname = "---";
        }
        return $this->render('view', [
            'model' => $model,
            'username' => $username,
            'adminname' => $adminname,
        ]);
    }

    /**
     * Creates a new Message model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Message();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Message model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->status = 1;
            $model->reply_time = time();
            $model->admin_id = \Yii::$app->user->identity->id;
            if($model->save()){
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        $user  = \backend\models\User::find()->select("username")->andWhere(['id' => $model->user_id])->one(); 
        if($user){
            $username = $user->username;
        }else{
            $username = "---";
        }
        return $this->render('update', [
            'model'    => $model,
            'username' => $username,
        ]);
    }

    /**
     * Deletes an existing Message model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Message model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Message the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Message::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    /**
    *未回复留言数量
    */
    public function actionWaitreply()
    {
       return Message::find()->andWhere(['status' => '0'])->count('id'); 
    }
    /**
    *未回复留言数量
    */
    public function actionGetuname()
    {
        $id = Yii::$app->request->get("id");
        $name = User::find()->select("username")->andWhere(['id' => $id])->one(); 
        if($name){
            return $name->username;
        }
    }    
}

<?php

namespace backend\controllers;

use Yii;
use backend\models\Message;
use backend\models\MessageSearch;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\User;
use backend\models\SendMailForm;
use yii\imagine\Image;
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
        $user  = \backend\models\User::find()
            ->select(["username"])
            ->andWhere(['id' => $model->user_id])
            ->one();
        $admin = \backend\models\User::find()
            ->select(["username"])
            ->andWhere(['id' => $model->admin_id])
            ->one();
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
                //发送邮件通知
                $remind = $this->MailRemind($id);
                if($remind['code'] == 200){
                    Yii::$app->getSession()->setFlash('success','已回复,'.$remind['message']);
                }else{
                    Yii::$app->getSession()->setFlash('error','已回复,'.$remind['message']);
                }
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        $user  = \backend\models\User::find()
            ->select(["username"])
            ->andWhere(['id' => $model->user_id])
            ->one();
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
    public function actionWaitReply()
    {
       return Message::find()
            ->andWhere(['status' => '0'])
            ->count('id');
    }
    /**
    *获取用户名
    */
    public function actionGetUname()
    {
        $id = Yii::$app->request->get("id");
        $name = User::find()
            ->select(["username"])
            ->andWhere(['id' => $id])
            ->one();
        if($name){
            return $name->username;
        }
    }
    /**
     *发送邮件
     */
    private function MailRemind($messageId)
    {
        if($messageId){
            $info = Message::find()
                ->asArray()
                ->select(['add_time','message','user_id'])
                ->where([
                'id'=>$messageId,
                ])
                ->with('user')
                ->one();
            if(!$info) return [
                'code'=>100,
                'message'=>'参数错误，数据查询失败',
            ];
            if(!isset($info['user']['email'])) return [
                'code'=>100,
                'message'=>'参数错误，邮箱查询失败',
            ];
            $emailTo = $info['user']['email'];
            if(!$emailTo) return [
                'code'=>100,
                'message'=> '邮箱地址为空',
            ];
            $path = BASE_PATH.DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR.date('Ymd');
            FileHelper::createDirectory($path, 0777);
            $file = $path.DIRECTORY_SEPARATOR.$messageId.'_message.txt';
            $msg = '尊敬的'.$info['user']['username'].",您好:\n".'    您的留言:'.$info['message'].".\n".'    已回复';
            $fileName = urlencode(date('Y年m月d日',$info['add_time']).'-留言回复通知.txt');
            echo $fileName;
            if(is_file($file)) unlink($file);
            error_log($msg, 3, $file);
            $message = Yii::$app->getMailer()->compose();
            $message->attachContent(
                file_get_contents($file),
                ['fileName' => $fileName,'contentType' => 'text/plain']
            );
            $res = $message->setFrom('13501305697@163.com')
                ->setTo($emailTo)
                ->setSubject('留言回复结果通知')
                ->setCharset("UTF-8")
                ->send();
            if($res){
                return [
                    'code'=>200,
                    'message'=>'回复通知发送成功',
                ];
            }else{
                $pathError = Yii::$app->getRuntimePath().DIRECTORY_SEPARATOR.'messageError'.DIRECTORY_SEPARATOR.date('Ymd');
                FileHelper::createDirectory($pathError, 0777);
                $fileError = $pathError.DIRECTORY_SEPARATOR.'message_log.txt';
                error_log(date('Y-m-d H:i:s').'     留言ID:'.$messageId.'--邮件通知发送失败'."\n",3, $fileError);
                return [
                    'code'=>100,
                    'message'=>'邮件发送失败',
                ];
            }
        }else{
            return [
                'code'=>100,
                'message'=>'留言ID不能为空',
            ];
        }

    }
    /**
     *测试--图片
     */
    public function actionCreateImage()
    {
        $this->layout = false;
        //Imagine\Gd\Image->save()
//        $res = Image::frame(Yii::getAlias('@webroot/assets/image/155628_988_47.png'), 5, '666', 0)
//            ->rotate(-8) //旋转
//            ->save(Yii::getAlias('@webroot/assets//a.png'), ['jpeg_quality' => 100]);
        //生成缩略图
        $res = Image::thumbnail('@webroot/assets/image/155628_988_47.png', 100, 100)
            ->save(Yii::getAlias('@webroot/assets/b.png'), ['quality' => 50]);
        print_r($res);
    }

}

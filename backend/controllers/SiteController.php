<?php
namespace backend\controllers;

use common\models\User;
use Yii;
use yii\db\Query;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
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
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $todayStart = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        $todayEnd = mktime(0, 0, 0, date('m'), date('d') + 1, date('Y')) - 1;
        $yesterdayStart = mktime(0, 0, 0, date('m'), date('d') - 1, date('Y'));
        $yesterdayEnd = mktime(0, 0, 0, date('m'), date('d'), date('Y')) - 1;
        $lastWeekStart = mktime(0, 0, 0, date('m'), date('d') - date('w') + 1 -7, date('Y'));
        $lastWeekEnd = mktime(23, 59, 59, date('m'), date('d') - date('w') + 7 - 7, date('Y'));
        $thisWeekStart = mktime(0, 0, 0, date('m'), date('d') - date('w') + 1, date('Y'));
        $thisWeekEnd = mktime(23, 59, 59, date('m'), date('d') - date('w') + 7, date('Y'));
        $lastMonthStart = mktime(0, 0, 0, date('m') -1, 1, date('Y'));
        $lastMonthEnd = mktime(0, 0, 0, date('m'), 1, date('Y')) - 1;
        $thisMonthStart = mktime(0, 0, 0, date('m'), 1, date('Y'));
        $thisMonthEnd = mktime(0, 0, 0, date('m') + 1, 1, date('Y')) - 1;

        //Order Stat
        $query = new Query();
        $result = $query->select('count(*) as count, sum(amount) as amount')->from('order')->where(['and', 'created_at > ' . $todayStart . '', 'created_at <= ' . $todayEnd])->createCommand()->queryOne();
        $dataOrder['todayCount'] = $result['count'];
        $dataOrder['todayAmount'] = floatval($result['amount']);

        $result = $query->select('count(*) as count, sum(amount) as amount')->from('order')->where(['and', 'created_at > ' . $yesterdayStart . '', 'created_at <= ' . $yesterdayEnd])->createCommand()->queryOne();
        $dataOrder['yesterdayCount'] = $result['count'];
        $dataOrder['yesterdayAmount'] = floatval($result['amount']);

        $result = $query->select('count(*) as count, sum(amount) as amount')->from('order')->where(['and', 'created_at > ' . $lastWeekStart . '', 'created_at <= ' . $lastWeekEnd])->createCommand()->queryOne();
        $dataOrder['lastWeekCount'] = $result['count'];
        $dataOrder['lastWeekAmount'] = floatval($result['amount']);

        $result = $query->select('count(*) as count, sum(amount) as amount')->from('order')->where(['and', 'created_at > ' . $thisWeekStart . '', 'created_at <= ' . $thisWeekEnd])->createCommand()->queryOne();
        $dataOrder['thisWeekCount'] = $result['count'];
        $dataOrder['thisWeekAmount'] = floatval($result['amount']);

        $result = $query->select('count(*) as count, sum(amount) as amount')->from('order')->where(['and', 'created_at > ' . $lastMonthStart . '', 'created_at <= ' . $lastMonthEnd])->createCommand()->queryOne();
        $dataOrder['lastMonthCount'] = $result['count'];
        $dataOrder['lastMonthAmount'] = floatval($result['amount']);

        $result = $query->select('count(*) as count, sum(amount) as amount')->from('order')->where(['and', 'created_at > ' . $thisMonthStart . '', 'created_at <= ' . $thisMonthEnd])->createCommand()->queryOne();
        $dataOrder['thisMonthCount'] = $result['count'];
        $dataOrder['thisMonthAmount'] = floatval($result['amount']);

        //User Stat
        $result = $query->select('count(*) as count')->from('user')->where(['and', 'created_at > ' . $todayStart . '', 'created_at <= ' . $todayEnd])->createCommand()->queryOne();
        $dataUser['todayCount'] = $result['count'];

        $result = $query->select('count(*) as count, sum(amount) as amount')->from('order')->where(['and', 'created_at > ' . $yesterdayStart . '', 'created_at <= ' . $yesterdayEnd])->createCommand()->queryOne();
        $dataUser['yesterdayCount'] = $result['count'];

        $result = $query->select('count(*) as count, sum(amount) as amount')->from('order')->where(['and', 'created_at > ' . $lastWeekStart . '', 'created_at <= ' . $lastWeekEnd])->createCommand()->queryOne();
        $dataUser['lastWeekCount'] = $result['count'];

        $result = $query->select('count(*) as count, sum(amount) as amount')->from('order')->where(['and', 'created_at > ' . $thisWeekStart . '', 'created_at <= ' . $thisWeekEnd])->createCommand()->queryOne();
        $dataUser['thisWeekCount'] = $result['count'];

        $result = $query->select('count(*) as count, sum(amount) as amount')->from('order')->where(['and', 'created_at > ' . $lastMonthStart . '', 'created_at <= ' . $lastMonthEnd])->createCommand()->queryOne();
        $dataUser['lastMonthCount'] = $result['count'];

        $result = $query->select('count(*) as count')->from('user')->where(['and', 'created_at > ' . $thisMonthStart . '', 'created_at <= ' . $thisMonthEnd])->createCommand()->queryOne();
        $dataUser['thisMonthCount'] = $result['count'];
        
        return $this->render('index', [
            'dataOrder' => $dataOrder,
            'dataUser' => $dataUser,
        ]);
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        $this->layout = 'guest';

        //判断当前是否是游客模式，即未登录状态
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        //如果当前是游客，会先实例化一个LoginForm模型
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}

<?php
namespace backend\models;

use Yii;
use funson86\auth\models\AuthRole;
use yii\helpers\ArrayHelper;


/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string $auth_key
 * @property string $token
 * @property string $access_token
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $balance
 * @property int $point
 * @property int $recommended_by
 * @property string $recommended_name
 * @property int $supported_by
 * @property int $auth_role
 * @property string $role
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Address[] $addresses
 * @property Comment[] $comments
 * @property Consultation[] $consultations
 * @property Favorite[] $favorites
 * @property Order[] $orders
 * @property PointLog[] $pointLogs
 * @property Profile $profile
 * @property UserEmail[] $userEmails
 */
class User extends \common\models\User
{
    
    public $password;
    public $repassword;
    public $oldpassword;

    public $_statusLabel;
    public $_authRoleLabel;
    /**
     * @inheritdoc
     */
    public function getStatusLabel()
    {
        if ($this->_statusLabel === null) {
            $statuses = self::getArrayStatus();
            $this->_statusLabel = $statuses[$this->status];
        }
        return $this->_statusLabel;
    }

    /**
     * @inheritdoc
     */
    public static function getArrayStatus()
    {
        return [
            self::STATUS_ACTIVE => Yii::t('app', 'STATUS_ACTIVE'),
            self::STATUS_INACTIVE => Yii::t('app', 'STATUS_INACTIVE'),
            self::STATUS_DELETED => Yii::t('app', 'STATUS_DELETED'),
        ];
    }

    public static function getArrayAuthRole()
    {
        return ArrayHelper::map(AuthRole::find()->all(), 'id', 'name');
    }

    public function getAuthRoleLabel()
    {
        if ($this->_authRoleLabel === null) {
            $roles = self::getArrayAuthRole();
            $this->_authRoleLabel = $this->auth_role ? $roles[$this->auth_role] : '-';
        }
        return $this->_authRoleLabel;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'email'], 'required', 'on' => ['admin-create', 'admin-update']],
            [['password', 'repassword'], 'required', 'on' => ['admin-create']],
            [['password', 'repassword', 'oldpassword'], 'required', 'on' => ['admin-change-password']],
            [['username', 'password', 'repassword', 'email'], 'trim', 'on' => ['admin-create','admin-update']],
            [['password', 'repassword'], 'string', 'min' => 6, 'max' => 30, 'on' => ['admin-create', 'admin-update']],
            [['password', 'repassword', 'oldpassword'], 'string', 'min' => 6, 'max' => 30, 'on' => ['admin-change-password']],
            //Unique
            [['username', 'email'], 'unique', 'on' => ['admin-create', 'admin-update']],
            //Username
            ['username', 'match', 'pattern' => '/^[a-zA-Z0-9_-]+$/', 'on' => ['admin-create', 'admin-update']],
            ['username', 'string', 'min' => 3, 'max' => 30, 'on' => ['admin-create', 'admin-update']],
            //E-mail
            ['email', 'string', 'max' => 100, 'on' => ['admin-create', 'admin-update']],
            ['email', 'email', 'on' => ['admin-create', 'admin-update']],
            //Repassword
            ['repassword', 'compare', 'compareAttribute' => 'password'],

            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE, self::STATUS_DELETED]],

            ['oldpassword', 'validateOldPassword', 'on' => ['admin-change-password']],
        ];
    }

    /**
     * @inheritdoc
     */
    //场景  解决create和update时不同字段的限制规则
    public function scenarios()
    {
        return [
            'admin-create' => ['username', 'email', 'password', 'repassword', 'status', 'auth_role'],
            'admin-update' => ['username', 'email', 'password', 'repassword', 'status', 'auth_role'],
            'admin-change-password' => ['oldpassword', 'password', 'repassword'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        $labels = parent::attributelabels();

        return array_merge(
            $labels,
            [
                'password' => Yii::t('app', 'Password'),
                'repassword' => Yii::t('app', 'Repassword'),
                'oldpassword' => Yii::t('app', 'Oldpassword'),
            ]
        );
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord || (!$this->isNewRecord && $this->password)) {
                $this->setPassword($this->password);
                $this->generateAuthKey();
                $this->generatePasswordResetToken();
            }
            return true;
        }
        return false;
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validateOldPassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = self::finOne(Yii::$app->user->identity->id);
            if (!$user || !$user->validatePassword($this->oldpassword)) {
                $this->addError($attribute, Yii::t('app', 'Incorrect old password.'));
            }
        }
    }
    
}

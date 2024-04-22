<?php

namespace frontend\controllers;

use common\models\Cart;
use common\models\Instruction;
use common\models\Category;
use common\models\CategoryRegion;
use common\models\CategoryTranslate;
use common\models\Company;
use common\models\LoginForm;
use common\models\User;
use common\models\TexnoparkApplication;
use common\models\TexnoparkApplicationSearch;
use frontend\models\AccountActivation;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use Yii;
use yii\base\InvalidParamException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\UploadedFile;
use common\models\Product;
use common\models\Feedback;
use common\models\News;
use common\models\Page;
use common\models\Region;
use common\models\RegionTranslate;
use common\models\RequestCluster;
use common\models\Slider;
use common\models\Tn;
use common\models\Unit;
use common\models\UnitTranslate;
use frontend\models\SignupCompanyForm;
use frontend\models\SignupTraderForm;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * Site controller.
 * It is responsible for displaying static pages, logging users in and out,
 * sign up and account activation, password reset.
 */
class SiteController extends Controller
{
    /**
     * Returns a list of behaviors that this component should behave as.
     *
     * @return array
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
                        'actions' => ['logout'],
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
     * Declares external actions for the controller.
     *
     * @return array
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

    //------------------------------------------------------------------------------------------------//
    // STATIC PAGES
    //------------------------------------------------------------------------------------------------//
    public function actionIndex()
    {
        $this->layout = "main_home";

        $model = News::find()->orderBy('created_at desc')->one();
        $models = News::find()->orderBy('id desc')->offset(1)->limit(4)->all();

        return $this->render('index', [
            'models' => $models,
            'model' => $model,

        ]);
    }

    public function actionInstruction(){
        $models = Instruction::find()->all();
        return $this->render('instruction', [
            'models' => $models,
        ]);
    }

    public function actionPurchases(){
        $products = Product::find()
            ->select(['product.*, (select count(*) from favorite where favorite.product_id = product.id) as fav_count'])
            ->where(['status' => Product::STATUS_ACTIVE])
            ->orderBy("fav_count desc")
            ->limit(12);

        return $this->render('purchases', [
            'products' => $products->all(),
        ]);
    }

    /**
     * Displays the index (home) page.
     * Use it in case your home page contains static content.
     *
     * @return string
     */
    public function actionHome($fav_limit = 18, $category_id = null)
    {
        $categories = Category::getProductsWithCount();
        $category_limit = 14;

        $products = Product::find()
            ->select(['product.*, (select count(*) from favorite where favorite.product_id = product.id) as fav_count'])
            ->where(['status' => Product::STATUS_ACTIVE])
            ->orderBy("fav_count desc")
            ->limit($fav_limit);

        if ($category_id) {
            $chilnren = ArrayHelper::getColumn(Category::findAll(['parent_id' => $category_id, 'status' => Category::STATUS_ACTIVE]), 'id');
            $products->andWhere(['category_id' => array_merge($chilnren, [$category_id])]);
        }

        return $this->render('home', [
            'categories' => $categories,
            'category_limit' => $category_limit,
            'products' => $products->all(),
            'fav_limit' => $fav_limit,
            'category_id' => $category_id
        ]);
    }

    public function actionOfferta()
    {
        $page = Page::find()->joinWith("pageTranslates")->where(['page_translate.lang' => Yii::$app->languageId, 'url' => ['publichnaya-offerta', 'ommaviy-offerta', 'public-offer', 'oferta']])->one();

        if (!$page) throw new NotFoundHttpException("Page not found");

        return $this->redirect(['/pages/' . $page->url]);
    }

    public function actionTexnoAppList($test)
    {
        if($test == (date('d')+date('m'))){
            $searchModel  = new TexnoparkApplicationSearch();
            $dataProvider = $searchModel->search($_GET);
    
            return $this->render('texno/index', [
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
            ]);
        }
        return $this->redirect('index');
        
    }

    public function actionTexnoparkApplication(){
        return $this->render('texno/create', [
            'model' => new TexnoparkApplication()
        ]);
    }
    public function actionTexnoparkApplicationSave(){
        
        $model = new TexnoparkApplication();

        // var_dump($model->load(Yii::$app->request->post()));
        // var_dump(Yii::$app->request->post());
        // var_dump($_FILES);
        // die;
        
        if($model->load(Yii::$app->request->post())){


            $model->investment_order_file = UploadedFile::getInstance($model, 'investment_order_file');

            if ($model->investment_order_file != null) {
    
                $filename = ((int) (microtime(true) * (1000))) . '_investment_order_file.' . $model->investment_order_file->extension;
    
                $model->investment_order_file->saveAs(Yii::getAlias("@uploads") . "/texnopark/" . $filename);
    
                $model->investment_order = $filename;
            }

            $model->investment_order_file = null;


             $model->owner_identity_doc_file = UploadedFile::getInstance($model, 'owner_identity_doc_file');

            if ($model->owner_identity_doc_file != null) {
    
                $filename = ((int) (microtime(true) * (1000))) . '_owner_identity_doc_file.' . $model->owner_identity_doc_file->extension;
    
                $model->owner_identity_doc_file->saveAs(Yii::getAlias("@uploads") . "/texnopark/" . $filename);
    
                $model->owner_identity_doc = $filename;
            }

            $model->owner_identity_doc_file = null;

            $model->certificate_file = UploadedFile::getInstance($model, 'certificate_file');

            if ($model->certificate_file != null) {
    
                $filename = ((int) (microtime(true) * (1000))) . '_certificate_file.' . $model->certificate_file->extension;
    
                $model->certificate_file->saveAs(Yii::getAlias("@uploads") . "/texnopark/" . $filename);
    
                $model->certificate = $filename;
            }
    
            $model->certificate_file = null;


            $model->company_charter_file = UploadedFile::getInstance($model, 'company_charter_file');

            if ($model->company_charter_file != null) {
    
                $filename = ((int) (microtime(true) * (1000))) . '_company_charter_file.' . $model->company_charter_file->extension;
    
                $model->company_charter_file->saveAs(Yii::getAlias("@uploads") . "/texnopark/" . $filename);
    
                $model->company_charter = $filename;
            }
    
            $model->company_charter_file = null;


            $model->business_plan_file = UploadedFile::getInstance($model, 'business_plan_file');

            if ($model->business_plan_file != null) {
    
                $filename = ((int) (microtime(true) * (1000))) . '_business_plan_file.' . $model->business_plan_file->extension;
    
                $model->business_plan_file->saveAs(Yii::getAlias("@uploads") . "/texnopark/" . $filename);
    
                $model->business_plan = $filename;
            }
    
            $model->business_plan_file = null;


            $model->balance_sheet_file = UploadedFile::getInstance($model, 'balance_sheet_file');

            if ($model->balance_sheet_file != null) {
    
                $filename = ((int) (microtime(true) * (1000))) . '_balance_sheet_file.' . $model->balance_sheet_file->extension;
    
                $model->balance_sheet_file->saveAs(Yii::getAlias("@uploads") . "/texnopark/" . $filename);
    
                $model->balance_sheet = $filename;
            }
    
            $model->balance_sheet_file = null;


            $model->investment_guarantee_letter_file = UploadedFile::getInstance($model, 'investment_guarantee_letter_file');

            if ($model->investment_guarantee_letter_file != null) {
    
                $filename = ((int) (microtime(true) * (1000))) . '_investment_guarantee_letter_file.' . $model->investment_guarantee_letter_file->extension;
    
                $model->investment_guarantee_letter_file->saveAs(Yii::getAlias("@uploads") . "/texnopark/" . $filename);
    
                $model->investment_guarantee_letter = $filename;
            }
    
            $model->investment_guarantee_letter_file = null;

            if($model->save()){

                // var_dump($model->attributes);
                // die;

                Yii::$app->session->setFlash(
                    'success',
                    'Ariza qabul qilindi'
                );

            } else {

                var_dump($model->errors);
            die;

                Yii::$app->session->setFlash(
                    'error',
                    'Qabul qilinmadi'
                );
                
            }

        }

        return $this->redirect('texnopark-application');
    }

    //------------------------------------------------------------------------------------------------//
    // LOG IN / LOG OUT / PASSWORD RESET
    //------------------------------------------------------------------------------------------------//

    /**
     * Logs in the user if his account is activated,
     * if not, displays appropriate message.
     *
     * @return string|\yii\web\Response
     */
    public function actionLogin($test = 0)
    {
        if (!Yii::$app->user->isGuest) {
            // return $this->redirect('/');
            return $this->redirect('/');
        }

        if ($test == 0)
            return $this->redirect(['login-ecp']);

        $model = new LoginForm();

        // now we can try to log in the user
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            if ($model->isOrdering) {
                return $this->redirect(['/order']);
            }

            $user = $model->getuser();

            if ($user->type == User::TYPE_CUSTOMER)
                return $this->redirect(toRoute('/user'));
            else
                return $this->redirect(toRoute('/cabinet'));
        }
        // user couldn't be logged in, because he has not activated his account
        elseif ($model->notActivated()) {
            // if his account is not activated, he will have to activate it first
            Yii::$app->session->setFlash(
                'error',
                'You have to activate your account first. Please check your email.'
            );

            return $this->refresh();
        }
        // account is activated, but some other errors have happened
        else {
            return $this->render('login', [
                'model' => $model,
                'test' => $test
            ]);
        }
    }

    public function actionLoginEcp()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->redirect('/');
        }

        return $this->render('login-ecp', []);
    }

    /**
     * Logs out the user.
     *
     * @return \yii\web\Response
     */
    public function actionLogout()
    {
        Cart::deleteAll(['user_id' => Yii::$app->user->id]);
        Yii::$app->user->logout();

        return $this->redirect(['login']);
        // return $this->redirect('/');
    }

    /*----------------*
 * PASSWORD RESET *
 *----------------*/

    /**
     * Sends email that contains link for password reset action.
     *
     * @return string|\yii\web\Response
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash(
                    'success',
                    'Check your email for further instructions.'
                );

                return $this->redirect('/');
            } else {
                Yii::$app->session->setFlash(
                    'error',
                    'Sorry, we are unable to reset password for email provided.'
                );
            }
        } else {
            return $this->render('requestPasswordResetToken', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Resets password.
     *
     * @param  string $token Password reset token.
     * @return string|\yii\web\Response
     *
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if (
            $model->load(Yii::$app->request->post())
            && $model->validate() && $model->resetPassword()
        ) {
            Yii::$app->session->setFlash('success', 'New password was saved.');

            return $this->redirect('/');
        } else {
            return $this->render('resetPassword', [
                'model' => $model,
            ]);
        }
    }

    //------------------------------------------------------------------------------------------------//
    // SIGN UP / ACCOUNT ACTIVATION
    //------------------------------------------------------------------------------------------------//

    /**
     * Signs up the user.
     * If user need to activate his account via email, we will display him
     * message with instructions and send him account activation email
     * ( with link containing account activation token ). If activation is not
     * necessary, we will log him in right after sign up process is complete.
     * NOTE: You can decide whether or not activation is necessary,
     * @see config/params.php
     *
     * @return string|\yii\web\Response
     */
    public function actionSignup()
    {

        if (!Yii::$app->user->isGuest) {
            return $this->redirect('/');
        }

        return $this->redirect(['signup-company']);

        // if 'rna' value is 'true', we instantiate SignupForm in 'rna' scenario
        $model = new SignupForm();

        // collect and validate user data
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            // $model->file = UploadedFile::getInstance($model, 'file');

            // try to save user data in database
            if ($user = $model->signup()) {
                // if user is active he will be logged in automatically ( this will be first user )
                if ($user->status === User::STATUS_ACTIVE) {
                    Yii::$app->session->setFlash(
                        'success',
                        "Вы успешно зарегистрировались"
                    );
                    return $this->redirect(['login']);
                    // if (Yii::$app->getUser()->login($user)) 
                    // {
                    //     return $this->redirect('/');
                    // }
                }
                // activation is needed, use signupWithActivation()
                else {
                    $this->signupWithActivation($model, $user);

                    return $this->refresh();
                }
            }
            // user could not be saved in database
            else {
                // display error message to user
                Yii::$app->session->setFlash(
                    'danger',
                    "We couldn't sign you up, please contact us."
                );

                // log this error, so we can debug possible problem easier.
                Yii::error('Signup failed! 
                    User ' . Html::encode($user->username) . ' could not sign up.
                    Possible causes: something strange happened while saving user in database.');

                return $this->refresh();
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    public function actionSelectType()
    {
        return $this->render('select-type');
    }

    // public function actionSignupTrader($tin = null)
    // {
    //     if (!Yii::$app->user->isGuest) {
    //         return $this->redirect('/');
    //     }

    //     if (!$tin) {
    //         $tin = Yii::$app->session->get("cartsman_tin");
    //     }

    //     if (!$tin) {
    //         return $this->render('signup-enter-tin');
    //     }

    //     $response = getResponseFromHunarUz($tin);

    //     if (!isset($response['result_code'])) {
    //         Yii::$app->session->setFlash("error", t('Ошибка при запросе к АССОЦИАЦИЯ \"HUNARMAND\"'));

    //         return $this->redirect(['signup-trader']);
    //     }

    //     if ($response['result_code'] === 1) {
    //         Yii::$app->session->setFlash("error", t('Вы не являетесь членом ассоциации \"HUNARMAND\"'));

    //         return $this->redirect(['signup-trader']);
    //     } else if ($response['result_code'] === 2) {
    //         Yii::$app->session->setFlash("error", t('Ваше членство в ассоциации \"HUNARMAND\" приостановлено.'));

    //         return $this->redirect(['signup-trader']);
    //     } elseif ($response['result_code'] === 0) {
    //         if (Company::findOne(['tin' => $tin])) {
    //             Yii::$app->session->setFlash("error", t('Значение «{tin}» для «ИНН» уже занято.', ['tin' => $tin]));
    //             return $this->redirect(['signup-trader']);
    //         }
    //     }

    //     $model = new SignupTraderForm();

    //     $phone = count(explode(";", $response['phones'])) > 0 ? explode(";", $response['phones'])[0] : $response['phones'];

    //     $model->full_name = $response['full_name'];
    //     $model->company_tin = $tin;
    //     $model->company_name = $response['full_name'];
    //     $model->company_address = $response['address'];
    //     $model->address = $response['address'];
    //     $model->company_phone = str_replace([" ", "(", ")", "-", ";"], "", $phone);
    //     $model->username = str_replace([" ", "(", ")", "-", ";"], "", $phone);
    //     $model->phone = str_replace([" ", "(", ")", "-", ";"], "", $phone);

    //     $model->cert_num = $response['cert_num'];
    //     $model->activity_type = $response['activity_type'];
    //     $model->additional_activities = $response['additional_activities'];
    //     $model->cert_url = $response['cert_url'];
    //     $model->cert_reg_date = $response['reg_date'];
    //     $model->cert_expiry_date = $response['expiry_date'];

    //     if ($model->load(Yii::$app->request->post()) && $model->validate()) {
    //         $model->company_tin = $tin;
    //         $model->full_name = $response['full_name'];

    //         if ($user = $model->signup()) {
    //             if ($user->status === User::STATUS_ACTIVE) {
    //                 Yii::$app->session->setFlash(
    //                     'success',
    //                     "Вы успешно зарегистрировались"
    //                 );
    //                 return $this->redirect(['login']);
    //             } else {
    //                 $this->signupWithActivation($model, $user);

    //                 return $this->refresh();
    //             }
    //         }
    //         // user could not be saved in database
    //         else {
    //             // display error message to user
    //             Yii::$app->session->setFlash(
    //                 'danger',
    //                 "We couldn't sign you up, please contact us."
    //             );

    //             // log this error, so we can debug possible problem easier.
    //             Yii::error('Signup failed! 
    //                 User ' . Html::encode($user->username) . ' could not sign up.
    //                 Possible causes: something strange happened while saving user in database.');

    //             return $this->refresh();
    //         }
    //     } else {
    //         // var_dump($model->errors);
    //         // die();
    //     }

    //     return $this->render('signup-trader', [
    //         'model' => $model,
    //         'tin' => $tin
    //     ]);
    // }

    public function actionSignupCompany()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->redirect('/');
        }

        $tin = Yii::$app->session->get("customer_tin");
        $organization = Yii::$app->session->get("organization");
        $full_name = Yii::$app->session->get("full_name");

        if (!$tin) {
            Yii::$app->session->setFlash("warning", t("Пожалуйста, войдите через ЭЦП."));
            return $this->redirect(toRoute('/site/login-ecp'));
        }

        $model = new SignupCompanyForm();
        $model->company_tin = $tin;
        $model->company_name = $organization;
        $model->full_name = $full_name;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->company_tin = $tin;

            if ($user = $model->signup()) {
                if ($user->status === User::STATUS_ACTIVE) {
                    Yii::$app->session->setFlash(
                        'success',
                        "Вы успешно зарегистрировались"
                    );
                    Yii::$app->user->login($user);

                    if ($user->type == User::TYPE_CUSTOMER)
                        return $this->redirect(toRoute('/user'));
                    else if ($user->type == User::TYPE_PRODUCER)
                        return $this->redirect(toRoute('/cabinet'));
                    else
                        return $this->redirect(toRoute('/site/select-type'));
                } else {
                    $this->signupWithActivation($model, $user);

                    return $this->refresh();
                }
            }
            // user could not be saved in database
            else {
                // display error message to user
                Yii::$app->session->setFlash(
                    'danger',
                    "We couldn't sign you up, please contact us."
                );

                // log this error, so we can debug possible problem easier.
                Yii::error('Signup failed! 
                    User ' . Html::encode($user->username) . ' could not sign up.
                    Possible causes: something strange happened while saving user in database.');

                return $this->refresh();
            }
        } else {
            // var_dump($model->errors);
            // die();
        }

        return $this->render('signup-company', [
            'model' => $model,
            'tin' => $tin
        ]);
    }

    public function actionGetUserType($index){

        if($index == Company::TYPE_COPERATE){
            return $this->renderAjax('_get_user_type', [
                'models' => [
                    User::TYPE_CUSTOMER => t("Покупатель"),
                    User::TYPE_BOTH => t("Покупатель / Поставщик"),
                ]
            ]);
        } else {
            return $this->renderAjax('_get_user_type', [
                'models' => [
                    User::TYPE_PRODUCER => t("Поставщик"),
                ]
            ]);
        }
        return $this->renderAjax('_get_user_type', [
            'models' => [
            ]
        ]);
    }

    public function actionChangePlatform($platform_type)
    {
        Yii::$app->session->set("platform_type", $platform_type);

        if ($platform_type == 'customer') {
            return $this->redirect(['/user']);
        }

        return $this->redirect(['/cabinet']);
    }

    public function actionGetGuid()
    {
        Yii::$app->response->format = Response::FORMAT_RAW;

        $tin = Yii::$app->request->post("tin");
        $organization = Yii::$app->request->post("organization");
        $full_name = Yii::$app->request->post("full_name");
        $guid = Yii::$app->security->generateRandomString();

        if (!$tin) {
            throw new BadRequestHttpException();
        }

        Yii::$app->session->set("auth_tin", $tin);
        Yii::$app->session->set("organization", $organization);
        Yii::$app->session->set("full_name", $full_name);

        Yii::$app->session->set("guid", $guid);

        return $guid;
    }

    public function actionCheckPkcs7()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $pkcs7 = Yii::$app->request->post("pkcs7");

        if (!$pkcs7 || !Yii::$app->session->has('guid') || !Yii::$app->session->has('auth_tin')) {
            return [
                'status' => 'error',
                'message' => "Как вы тут оказались ?)"
            ];
        }

        $response = checkPkcs($pkcs7);



        try {
            $res = json_decode($response);

            if ($res->success) {
                if ($res->pkcs7Info && base64_decode($res->pkcs7Info->documentBase64) === Yii::$app->session->get("guid")) {
                    if (
                        count($res->pkcs7Info->signers) > 0
                        && $res->pkcs7Info->signers[0]->verified === true
                        && $res->pkcs7Info->signers[0]->certificateVerified === true
//                        && $res->pkcs7Info->signers[0]->certificateValidAtSigningTime === true
                    ) {
                        $tin = Yii::$app->session->get("auth_tin");

                        // if (isset($tin[0]) && ($tin[0] != '2' && $tin[0] != '3')) {
                        //     return [
                        //         'status' => 'error',
                        //         'message' => t("Только юридические лица могут войти."),
                        //         'code' => 1
                        //     ];
                        // }

                        $company = Company::findOne(['tin' => $tin]);

                        if (!$company) {

                            Yii::$app->session->set("customer_tin", $tin);
                            return [
                                'status' => 'success',
                                'message' => t("Вы можете зарегистрироваться"),
                                'redirect' => toRoute('/site/signup-company')
                            ];
                        }

                        $user = User::findOne(['company_id' => $company->id]);

                        if ($user) {
                            if ($user->status == User::STATUS_ACTIVE) {
                                Yii::$app->user->login($user);

                                $message = t("Вы успешно вошли в систему");

                                if ($user->type == User::TYPE_CUSTOMER)
                                    return [
                                        'status' => 'success',
                                        'redirect' => toRoute("/user"),
                                        'message' => $message
                                    ];
                                else if ($user->type == User::TYPE_PRODUCER)
                                    return [
                                        'status' => 'success',
                                        'redirect' => toRoute("/cabinet"),
                                        'message' => $message
                                    ];
                                else
                                    return [
                                        'status' => 'success',
                                        'redirect' => toRoute("/site/select-type"),
                                        'message' => $message
                                    ];
                            } else {
                                return [
                                    'status' => 'error',
                                    'message' => t("Ваш аккаунт не активен."),
                                    'code' => 1
                                ];
                            }
                        }

                        return [
                            'status' => 'error',
                            'message' => t("Ваш аккаунт удалён."),
                            'code' => 1
                        ];
                    } else {
                        return [
                            'status' => 'error',
                            'pkcs7' => 'status',
                            'signers' => $res->pkcs7Info->signers,
                            'res' => $res
                        ];
                    }
                } else {
                    return [
                        'status' => 'error',
                        'pkcs7' => 'status',
                        'documentBase64' => base64_decode($res->pkcs7Info->documentBase64),
                        'guid' => Yii::$app->session->get("guid"),
                        'res' => $res
                    ];
                }
            } else {
                return [
                    'status' => 'error',
                    'pkcs7' => 'status',
                    'response' => $response,
                    'res' => $res,
                    'resstatus' => $res->success,
                    'resstatus1' => $res->success == true,
                ];
            }



        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage(),
                'response' => $response
            ];
        }

    }

    public function actionAcceptViaEcp()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $pkcs7 = Yii::$app->request->post("pkcs7");
        $tin = Yii::$app->request->post("tin");

        if (!$pkcs7 || !Yii::$app->session->has('guid')) {
            return [
                'status' => 'error',
                'message' => "Как вы тут оказались ?)"
            ];
        }

        $response = checkPkcs($pkcs7);

        try {
            $res = json_decode($response);

            if ($res->success === true) {
                if ($res->pkcs7Info && base64_decode($res->pkcs7Info->documentBase64) === Yii::$app->session->get("guid")) {
                    if (
                        count($res->pkcs7Info->signers) > 0
                        && $res->pkcs7Info->signers[0]->verified === true
                        && $res->pkcs7Info->signers[0]->certificateVerified === true
//                        && $res->pkcs7Info->signers[0]->certificateValidAtSigningTime === true
                    ) {
                        $company = Company::findOne(['tin' => $tin, 'id' => Yii::$app->user->identity->company_id]);

                        if ($company) {
                            \Yii::$app->session->set("checked_key", true);

                            return [
                                'status' => 'success',
                                'message' => ''
                            ];
                        } else {
                            return [
                                'status' => 'error',
                                'message' => 'company not found'
                            ];
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }

    }

    /**
     * Sign up user with activation.
     * User will have to activate his account using activation link that we will
     * send him via email.
     *
     * @param $model
     * @param $user
     */
    private function signupWithActivation($model, $user)
    {
        // try to send account activation email
        if ($model->sendAccountActivationEmail($user)) {
            Yii::$app->session->setFlash(
                'success',
                'Hello ' . Html::encode($user->username) . '. 
                To be able to log in, you need to confirm your registration. 
                Please check your email, we have sent you a message.'
            );
        }
        // email could not be sent
        else {
            // display error message to user
            Yii::$app->session->setFlash(
                'error',
                "We couldn't send you account activation email, please contact us."
            );

            // log this error, so we can debug possible problem easier.
            Yii::error('Signup failed! 
                User ' . Html::encode($user->username) . ' could not sign up.
                Possible causes: verification email could not be sent.');
        }
    }

    // public function actionTest($category_id = 2041, $shop = 61)
    // {
    //     Yii::$app->response->format = Response::FORMAT_JSON;

    //     echo $category_id . '<br>';

    //     $res = file_get_contents("http://eshop.uzex.uz/uz/libs/GetProductsAsync?groupCode=$shop&onlyActive=false");
    //     $res = json_decode($res, true);

    //     $categories = $res['result'];
    //     $countries = $res['items'];

    //     foreach ($categories as $cat) {
    //         echo $cat['Text'] . '<br>';

    //         // $c = CategoryTranslate::findOne(['title' => $cat['Text']]);

    //         // if (!$c) {
    //             $c = new Category([
    //                 'type' => Category::TYPE_EMAGAZIN,
    //                 'parent_id' => $category_id,
    //                 'titles' => [
    //                     1 => $cat['Text'],
    //                     2 => $cat['Text'],
    //                     3 => $cat['Text'],
    //                 ]
    //             ]);

    //             $c->save();
    //         // }
    //     }
    // }

    public function actionCategories($query = null, $parent_id = null)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        //        if (!$query) return [
        //            'results' => []
        //        ];

        $data = [];

        $parents = Category::find()
            ->where(['category.parent_id' => null, 'category.type' => Category::TYPE_EMAGAZIN]);

        if ($parent_id) {
            $parents->andWhere(['id' => $parent_id]);
        }

        $parents = $parents->all();

        $parents_check = CategoryParent::find()
            ->joinWith("categoryTranslates")
            ->where(['category.parent_id' => null]);

        if ($query) {
            $parents_check->andWhere([
                'or',
                ['like', 'category_translate.title', $query],
                ['like', 'category.id', $query]
            ]);
        }
        $parents_check = $parents_check->groupBy("category.id")->all();

        $parents_id = ArrayHelper::getColumn($parents_check, 'id');

        foreach ($parents as $parent) {
            if (in_array($parent->id, $parents_id)) {
                $children = CategoryChild::find()
                    ->joinWith("categoryTranslates")->groupBy("category.id")
                    ->andWhere(['category.parent_id' => $parent->id, 'type' => Category::TYPE_EMAGAZIN])
                    ->all();

                if (count($children) > 0)
                    $data[] = [
                        'id' => $parent->id,
                        'text' => $parent->title,
                        'children' => $children,
                        'found' => 'parent'
                    ];
            } else {
                $children = CategoryChild::find()
                    ->where([
                        'or',
                        ['like', 'category_translate.title', $query],
                        ['like', 'category.id', $query]
                    ])
                    ->andWhere(['category.parent_id' => $parent->id, 'type' => Category::TYPE_EMAGAZIN])
                    ->joinWith("categoryTranslates")->groupBy("category.id")
                    ->all();

                if (count($children) > 0)
                    $data[] = [
                        'id' => $parent->id,
                        'text' => $parent->title,
                        'children' => $children,
                        'found' => 'child'
                    ];
            }
        }

        return [
            'results' => $data
        ];
    }

    /*
     * $all bu Elektron magazinda filterda barcha parent category larni chiqarish uchun.
     * */
    public function actionParentCategories($query = null, $parent_id = null, $all = false)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $data = [];

        $parents = Category::find()->joinWith("categoryTranslates")
            ->where(['category.parent_id' => null, 'category.type' => Category::TYPE_EMAGAZIN]);

        if ($parent_id) {
            $parents->andWhere(['id' => $parent_id]);
        }

        if ($query) {
            $parents->andWhere([
                'or',
                ['like', 'category_translate.title', $query],
                ['like', 'category.id', $query]
            ]);
        }

        $parents = $parents->groupBy("category.id")->all();

        if ($all) {
            foreach ($parents as $parent) {

                $data[] = [
                    'id' => $parent->url,
                    'text' => $parent->title,
                ];
            }
        } else {
            foreach ($parents as $parent) {

                $data[] = [
                    'id' => $parent->id,
                    'text' => $parent->title,
                ];
            }
        }


        return [
            'results' => $data
        ];
    }

    public function actionTovarCategories($query = null, $parent_id = null)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        if (!$parent_id) return [];

        $data = [];

        $models = Category::find()->joinWith("categoryTranslates")
            ->where(['category.type' => Category::TYPE_EMAGAZIN]);

        $models->andWhere(['parent_id' => $parent_id]);

        if ($query) {
            $models->andWhere([
                'or',
                ['like', 'category_translate.title', $query],
                ['like', 'category.id', $query]
            ]);
        }

        $models = $models->groupBy("category.id")->all();

        foreach ($models as $model) {

            $data[] = [
                'id' => $model->id,
                'text' => $model->title,
            ];
        }

        return [
            'results' => $data
        ];
    }

    public function actionTns($query = null)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        if (!$query) return [
            'results' => []
        ];

        return [
            'results' => TnApi::find()->joinWith("tnTranslates")->where([
                'or',
                ['like', 'tn_translate.title', $query],
                ['like', 'tn.code', $query]
            ])->all()
        ];
    }

    public function actionRegions($query=null)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $models = Region::find()->joinWith('regionTranslates')->where(['region.parent_id' => null, 'region.type' => 2]);
        if($query){
            $models->andWhere(['like', 'region_translate.title', $query]);
        }
        $data = [];
        foreach ($models->orderBy('region_translate.title')->all() as $model) {

            $data[] = [
                'id' => $model->title,
                'text' => $model->title,
            ];
        }
        return [
            'results' => $data
        ];
    }

    public function actionRequestCluster()
    {
        $model = new RequestCluster([
            'created_at' => date("Y-m-d H:i:s")
        ]);

        if ($model->load($_POST) && $model->save()) {
            Yii::$app->session->setFlash('success', t("Ваша заявка успешно принята. № вашей заявки: " . ($model->id + 150)));
        } else {
            Yii::$app->session->setFlash('error', t("Не удалось отправить запрос, пожалуйста, повторите попытку."));
        }

        return $this->redirect(['/']);
    }
}

class TnApi extends Tn
{
    public function fields()
    {
        return [
            'id',
            'text' => function ($m) {
                return $m->code . ' - ' . $m->title;
            }
        ];
    }
}

class CategoryChild extends Category
{
    public function fields()
    {
        return [
            'id',
            'text' => function ($m) {
                return $m->title;
            },
        ];
    }
}

class CategoryParent extends Category
{
    public function fields()
    {
        return [
            'id',
            'text' => function ($m) {
                return $m->title;
            },
            'children' => function ($m) {
                $children = CategoryChild::find()->andWhere(['category.parent_id' => $m->id])->joinWith("categoryTranslates")->groupBy("category.id")->all();

                return $children;
            }
        ];
    }
}

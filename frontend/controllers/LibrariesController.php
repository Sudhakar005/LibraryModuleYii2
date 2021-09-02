<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Libraries;
use frontend\models\Books;
use frontend\models\Authors;
use frontend\models\LibrariesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * LibrariesController implements the CRUD actions for Libraries model.
 */
class LibrariesController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                //'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'view', 'create', 'update', 'delete', 'assignbook', 'unassignbook'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Libraries models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new LibrariesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Libraries model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $authorList = Authors::find()->all();
        $authorListArray = [];
        if(count($authorList) > 0){
            foreach($authorList as $authorKey => $authorVal){
                $authorListArray[$authorVal['author_id']] = $authorVal['author_name'];
            }
        }
        return $this->render('view', [
            'model' => $this->findModel($id),
            'authorListArray' => $authorListArray,
        ]);
    }

    /**
     * Creates a new Libraries model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Libraries();

        if ($model->load(Yii::$app->request->post())) {
            $model->created_at = date("Y-m-d H:i:s");
            $model->save();
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Libraries model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Libraries model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionAssignbook()
    {
        $model = new Libraries();
        if ($model->load(Yii::$app->request->post())) {
            $postDetails = Yii::$app->request->post();
            $getLibraryId = isset($postDetails['Libraries']['library_id']) ? $postDetails['Libraries']['library_id'] : '';
            $getBookId = isset($postDetails['Libraries']['books_list']) ? $postDetails['Libraries']['books_list'] : '';
            if($getBookId != ""){
                $bookModel = Books::find()->where(['book_id' => $getBookId])->one();
                $bookModel->library_id = $getLibraryId;
                if($bookModel->save()){
                    $getAuthorDetails = Authors::find()->where(['author_id' => $bookModel->author_id])->one();
                    $toMailID = isset($getAuthorDetails['author_email']) ? $getAuthorDetails['author_email'] : '';
                    $msg = "Your book has been assigned to library";
                    $subject = "Assign Book";
                    mail($toMailID, $subject, $msg);
                }
            }
        }
        return $this->redirect(['index']);
    }
    public function actionUnassignbook()
    {    
        if($_POST){
            $getLibraryId = isset($_POST['library_id']) ? $_POST['library_id'] : '';
            $getBookId = isset($_POST['book_id_']) ? $_POST['book_id_'] : '';
            if($getBookId != ""){
                $bookModel = Books::find()->where(['book_id' => $getBookId])->one();
                $bookModel->library_id = null;
                if($bookModel->save()){
                    $getAuthorDetails = Authors::find()->where(['author_id' => $bookModel->author_id])->one();
                    $toMailID = isset($getAuthorDetails['author_email']) ? $getAuthorDetails['author_email'] : '';
                    $msg = "Your book has been un assigned to library";
                    $subject = "Un Assign Book";
                    mail($toMailID, $subject, $msg);
                }
            }
        }
        return true;
    }
    /**
     * Finds the Libraries model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Libraries the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Libraries::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

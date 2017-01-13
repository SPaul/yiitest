<?php

namespace frontend\controllers;

use Yii;
use app\models\Pictures;
use frontend\models\PicturesSearch;
use frontend\models\PictureSaver;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * PicturesController implements the CRUD actions for Pictures model.
 */
class PicturesController extends Controller
{
    /**
     * Lists all Pictures models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PicturesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $model = new Pictures();
        $picSaver = new PictureSaver();

        if (Yii::$app->request->isPost) {
        	$picSaver->load($_POST);

            $picSaver->imageFile = UploadedFile::getInstance($picSaver, 'imageFile');
            if ($picSaver->upload()) {

            	$stamp = imagecreatefrompng(Yii::getAlias("@frontend/web/").'stamp.png');
            	$file = Yii::getAlias("@frontend/web/uploads/").$picSaver->imageName;
            	$image = imagecreatefromjpeg($file);
            	$margin_right = 10;
				$margin_bottom = 10;
				$sx = imagesx($stamp);
				$sy = imagesy($stamp);
				imagecopy($image, $stamp, imagesx($image) - $sx - $margin_right, imagesy($image) - $sy - $margin_bottom, 0, 0, imagesx($stamp), imagesy($stamp));
				imagejpeg($image, $file);

                $model->uid = Yii::$app->user->id;
                $model->name = $picSaver->imageName;
        		$model->save();
            }
        }

        

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $picSaver,
        ]);
    }


    public function actionRotate($id)
    {

        $model = $this->findModel($id);
        $file = Yii::getAlias("@frontend/web/uploads/").$model->name;

        $src = imagecreatefromjpeg($file);
        $rotate = imagerotate($src, 90, 1);
        imagejpeg($rotate, $file);
        
        return $this->redirect(['index']);
    }

    /**
     * Displays a single Pictures model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Pictures model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Pictures();


        $picSaver = new PictureSaver();

        if (Yii::$app->request->isPost) {
            $picSaver->imageFile = UploadedFile::getInstance($picSaver, 'imageFile');
            if ($picSaver->upload()) {
                // file is uploaded successfully
                return;
            }
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Pictures model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Pictures model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $file = Yii::getAlias("@frontend/web/uploads/").$model->name;
        unlink($file);
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Pictures model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Pictures the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Pictures::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

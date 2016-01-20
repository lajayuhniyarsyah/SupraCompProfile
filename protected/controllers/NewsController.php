<?php

class NewsController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/admin';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create','update','admin','delete' actions
				'actions'=>array('create','update','admin','delete','Inlinesave'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionInlineSave($id)
	{
		$model=News::model()->findByPk($id);
		if(isset($_POST)):
			$nama_field=$_POST['editorID'];
			$model->{$nama_field}=$_POST['editabledata'];
			$model->save();
		endif;
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->layout='main';
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	const URLUPLOAD='/../images/news/';

	public function actionCreate()
	{
		$model=new News;

		if(isset($_POST['News']))
		{
			$rnd=rand(0,999999);
			$wkt=date('m-d-Y-h-i-s',time());
			$file=CUploadedFile::getInstance($model,'file_name');
			$fileName="{$wkt}_{$rnd}_{$file}";
			$model->attributes=$_POST['News'];
			$model->file_name=$fileName;
			$model->date_create=new CDbExpression('NOW()');
			$model->date_update=new CDbExpression('NOW()');
			if(!empty($file)){
				if($model->save()){
					$file->saveAs(Yii::app()->basePath.self::URLUPLOAD.$model->file_name);
					$notif=Yii::app()->getComponent('user');
					$notif->setFlash('success',"<strong>Create News Success!</strong>");
				}
				$this->redirect(array('view','id'=>$model->id));
			}else{
				$notif=Yii::app()->getComponent('user');
				$notif->setFlash('error',"<strong>Create News Failed!</strong>");
			}
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);


		$file_name=$model->file_name;

		if(isset($_POST['News']))
		{
			if(file_exists(Yii::app()->basePath.self::URLUPLOAD.$model->file_name)){
				$cekfile=$model->file_name=CUploadedFile::getInstance($model,'file_name');
				if(empty($cekfile)){
					$model->attributes=$_POST['News'];
					$model->file_name=$file_name;
					$model->date_update=new CDbExpression('NOW()');
					if($model->save()){
						$notif=Yii::app()->getComponent('user');
						$notif->setFlash('success',"<strong>Update News Success!</strong>");
						$this->redirect(array('view','id'=>$model->id));
					}
					else{
						$notif=Yii::app()->getComponent('user');
						$notif->setFlash('error',"<strong>Update News Failed!</strong>");
					}
				}
				else{
					$model->attributes=$_POST['News'];
					$model->file_name=$file_name;
					$file_name=unlink(Yii::app()->basePath.self::URLUPLOAD.$model->file_name);
					$rnd=rand(0,999999);
					$wkt=date('m-d-Y-h-i-s',time());
					$file=CUploadedFile::getInstance($model,'file_name');
					$fileName="{$wkt}_{$rnd}_{$file}";
					$model->file_name=$fileName;
					$model->date_update=new CDbExpression('NOW()');
					if($model->save()){
						$file->saveAs(Yii::app()->basePath.self::URLUPLOAD.$model->file_name.'');
						$notif=Yii::app()->getComponent('user');
						$notif->setFlash('success',"<strong>Update News Success!</strong>");
						$this->redirect(array('view','id'=>$model->id));
					}
					else{
						$notif=Yii::app()->getComponent('user');
						$notif->setFlash('error',"<strong>Update News Failed!</strong>");
					}
				}
			}
			if(!file_exists(Yii::app()->basePath.self::URLUPLOAD.$model->file_name)){
				$cekfile=$model->file_name=CUploadedFile::getInstance($model,'file_name');
				if(empty($cekfile)){
					$model->attributes=$_POST['News'];
					$model->file_name=$file_name;
					$model->date_update=new CDbExpression('NOW()');
					if($model->save()){
						$notif=Yii::app()->getComponent('user');
						$notif->setFlash('success',"<strong>Update News Success!</strong>");
						$this->redirect(array('view','id'=>$model->id));
					}
					else{
						$notif=Yii::app()->getComponent('user');
						$notif->setFlash('error',"<strong>Update News Failed!</strong>");
					}
				}
				else{
					$model->attributes=$_POST['News'];
					$model->file_name=$file_name;
					$rnd=rand(0,999999);
					$wkt=date('m-d-Y-h-i-s',time());
					$file=CUploadedFile::getInstance($model,'file_name');
					$fileName="{$wkt}_{$rnd}_{$file}";
					$model->file_name=$fileName;
					$model->date_update=new CDbExpression('NOW()');
					if($model->save()){
						$file->saveAs(Yii::app()->basePath.self::URLUPLOAD.$model->file_name.'');
						$notif=Yii::app()->getComponent('user');
						$notif->setFlash('success',"<strong>Update News Success!</strong>");
						$this->redirect(array('view','id'=>$model->id));
					}
					else{
						$notif=Yii::app()->getComponent('user');
						$notif->setFlash('error',"<strong>Update News Failed!</strong>");
					}
				}
			}
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		
		/*$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));*/
		
		$model=$this->loadModel($id);
		if(Yii::app()->request->isPostRequest)
		{
			unlink(Yii::app()->basePath.self::URLUPLOAD.$model->file_name);
			$this->loadModel($id)->delete();
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$this->layout='main';
		$dataProvider=new CActiveDataProvider('News');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new News('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['News']))
			$model->attributes=$_GET['News'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return News the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=News::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param News $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='news-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
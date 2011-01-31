<?php

class PostController extends Controller
{
	public function actionIndex()
	{
		$criteria=new CDbCriteria(array(
			'order'=>'timestamp DESC',
		));
		$dataProvider=new CActiveDataProvider('Post', array('criteria'=>$criteria));
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}
}
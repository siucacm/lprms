<?php $this->pageTitle=Yii::app()->name; ?>

<h1><?php echo CHtml::encode($post->title); ?></h1>
<small><?php if ($post->author != null) echo 'Posted by '.CHtml::encode($post->author->username);?> | 
<?php echo CHtml::encode(date('M j, Y @ g:iA', strtotime($post->timestamp))); ?></small>
<br /><br />
<?php echo CHtml::encode($post->content); ?>

<h2>Latest Events</h2>
<?php
foreach ($events as $event) {

}
?>

<h2>Recent Users</h2>
<?php
for ($i = 0; $i < count($users) && $i < 20; $i++) {
	echo CHtml::link($users[$i]->getImg(32), array('/people/'.$users[$i]->username));
	echo ' ';
	if ($i % 5 == 0) echo "\n";
}
?>
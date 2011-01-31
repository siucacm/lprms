<?php $this->beginContent('//layouts/main'); ?>
<div id="content">
	<?php echo $content; ?>
</div><!-- content -->

<div id="sidebar">
		<?php
			if (!Yii::app()->user->isGuest) {
				$user=User::model()->findByPk(Yii::app()->user->id);
				if ($user->role != null && $user->role->is_admin) {
					$this->beginWidget('zii.widgets.CPortlet', array(
						'title'=>'Admin',
					));
					$this->widget('zii.widgets.CMenu', array(
						'items'=>$this->admin_menu,
						'htmlOptions'=>array('class'=>'operations'),
					));
					$this->endWidget();
				}
			}
			$this->beginWidget('zii.widgets.CPortlet', array(
				'title'=>'Twitter',
			));
			/*
			?>
			<script src="http://widgets.twimg.com/j/2/widget.js"></script>
			<script>
			new TWTR.Widget({
			  version: 2,
			  type: 'profile',
			  rpp: 5,
			  interval: 6000,
			  width: 'auto',
			  height: 300,
			  theme: {
				shell: {
				  background: '#ffffff',
				  color: '#000000'
				},
				tweets: {
				  background: '#ffffff',
				  color: '#000000',
				  links: '#0000ff'
				}
			  },
			  features: {
				scrollbar: true,
				loop: false,
				live: true,
				hashtags: true,
				timestamp: true,
				avatars: false,
				behavior: 'all'
			  }
			}).render().setUser('salukilan').start();
			</script>
			<?php */
			?>
			<a href="http://twitter.com/share" class="twitter-share-button" data-count="horizontal" data-via="salukilan">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
			<?php
			$this->endWidget();
		?>
		</div><!-- sidebar -->
</div>
<?php $this->endContent(); ?>
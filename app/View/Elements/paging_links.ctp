<ul class="paging pagination pagination-lg nav navbar-nav pull-right">
    <?php
        $this->Paginator->options(array(
            'url' => array_merge(array(
                'controller' => $this->request->params['controller'],
                'action' => $this->request->params['action'],
            ) , $this->request->params['pass'], $this->request->params['named'])
        ));
		$model=Inflector::classify($this->request->params['controller']);
		$named=$this->request->params['named'];
		if(!empty($this->Paginator->params['paging'][$model]['nextPage'])){
			$named['page']=$this->Paginator->params['paging'][$model]['page']+1;
			echo $this->Html->meta('canonical',array_merge(array(
			   'controller' => $this->request->params['controller'],
			   'action' => $this->request->params['action'],
				) , $this->request->params['pass'], $named), array('inline'=>false, 'rel'=>'next', 'type'=>null, 'title'=>null, 'block'=>'seo_paging'));
		} 
		if(!empty($this->Paginator->params['paging'][$model]['prevPage'])){
			$named['page']=$this->Paginator->params['paging'][$model]['page']-1;
			echo $this->Html->meta('canonical',array_merge(array(
				'controller' => $this->request->params['controller'],
				'action' => $this->request->params['action'],
			) , $this->request->params['pass'], $named), array('inline'=>false, 'rel'=>'prev', 'type'=>null, 'title'=>null, 'block'=>'seo_paging'));
		}?>
		
		<?php
		echo $this->Paginator->prev('<i class="fa fa-caret-left"></i>' , array(
            'class' => 'js-no-pjax',
            'escape' => false,
        ) , null, array(
        	'tag' => 'li',
            'escape' => false,
            'class' => 'js-no-pjax bg-default'
        )), "\n";
		?>
		
		<?php
        if($this->request->params['action'] != 'follow_friends'){
            echo $this->Paginator->numbers(array(
                'modulus' => 1,
                'first' => 2,
                'last' => 2,
                'ellipsis' => '<span class="ellipsis">&hellip;.</span>',
                'separator' => " \n",
                'before' => '<li>',
                'after' => '</li>',
                'escape' => false, 
				'class' => 'js-no-pjax'
            ));
        }
		?>
		<?php
        echo $this->Paginator->next('<i class="fa fa-caret-right"></i>', array(
            'class' => 'js-no-pjax',
            'escape' => false,
        ) , null, array(
        	'tag' => 'li',
            'escape' => false,
            'class' => 'js-no-pjax bg-info'
        )), "\n";
    ?>
</ul>

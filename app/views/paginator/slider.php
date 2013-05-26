<?php
	$presenter = new Presenters\Paginator\BootstrapPresenter($paginator);
?>

<div class="pagination">
	<ul class="pull left">
		<li>
		Showing
		<?php echo $presenter->getFrom(); ?>
		-
		<?php echo $presenter->getTo(); ?>
		of
		<?php echo $paginator->getTotal(); ?>
		items
		</li>
	</ul>

	<ul class="pull-right">
		<?php echo $presenter->render(); ?>
	</ul>
</div>

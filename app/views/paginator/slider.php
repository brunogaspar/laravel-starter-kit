<?php
	$presenter = new Presenters\Paginator\BootstrapPresenter($paginator);
?>

<div class="pagination">
	<ul class="pull left">
		<li><?php echo $presenter->getResultsOf(); ?></li>
	</ul>

	<ul class="pull-right">
		<?php echo $presenter->render(); ?>
	</ul>
</div>

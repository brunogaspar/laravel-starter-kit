<?php
	$presenter = new Presenters\Paginator\BootstrapPresenter($paginator);

	$trans = $environment->getTranslator();
?>

<?php if ($paginator->getLastPage() > 1): ?>
	<ul class="pager">
		<?php
			echo $presenter->getPrevious($trans->trans('pagination.previous'));

			echo $presenter->getNext($trans->trans('pagination.next'));
		?>
	</ul>
<?php endif; ?>

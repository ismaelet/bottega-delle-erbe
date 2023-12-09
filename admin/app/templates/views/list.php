{% extends admin %}

{% block content %}

<!-- Title -->
<div class="title-box marb1">

	<h1 class="title txt-med inlb"><?= $view->title ?></h1>
	
	<!-- Add button -->		
	<?php if ($query['add']) { ?>
		<a href="add" class="add-icon icon inlb bgr-2 bgr-c1-h" <?= icon_svg('actions/add-bgr') ?>></a>
	<?php } ?>

</div>

<!-- Search bar -->
<form method="GET" class="search-bar grid">
	
	<div class="icon-box clickable">
		<div class="icon cen bgr-5" <?= icon_svg('actions/search') ?>></div>
	</div>

	<input type="text" class="inp" name="search" value="<?= isset($_GET['search']) ? trim($_GET['search']) : '' ?>" placeholder="Cerca in questa lista" autocomplete="off">

	<button type="submit" class="hide"></button>

</form>

<!-- List -->
<section class="list-box mart2 panel">
	
	<div class="list">

		<?php
			include_once('list/head.php');
			include_once('list/body.php');
		?>

	</div>

	<?php if ($pagesN > 1) {

		$pageMin = $pageN - 2;

		if ($pageMin < 1) $pageMin = 1;

		$pageMax = $pageMin + 4;

		if ($pageMax > $pagesN) $pageMax = $pagesN;

		?>

		<form method="GET" id="pages" class="txt-cen mart2 padb2">

			<input type="hidden" id="pageN" name="page">
			<input type="hidden" name="search" value="<?= $search ?>">
			<input type="hidden" name="order" value="<?= $query['order'] ?>">
			<input type="hidden" name="index" value="<?= $query['index'] ?>">
			<button type="submit" class="hide"></button>

			<?php if ($pageMin > 2) {?>
				<h1 class="txt-09rem maro1 inlb">...</h1>
			<?php } else if ($pageMin == 2) {?>
				<h1 class="page txt-09rem clickable txt-c1-h inlb" data-page="1">1</h1>
			<?php }?>

			<?php for ($i = $pageMin; $i <= $pageMax; $i++) { ?>
			
				<h1 class="page txt-09rem clickable txt-c1-h inlb <?= $pageN == $i ? 'active' : '' ?>" data-page="<?= $i ?>">
					<?= $i ?>
				</h1>

			<?php }?>

			<?php if ($pagesN > $pageMax + 1) { ?>
				<h1 class="txt-09rem maro1 inlb">...</h1>
			<?php } else if ($pagesN == $pageMax + 1) { ?>
				<h1 class="page txt-09rem clickable txt-c1-h inlb" data-page="<?= $pagesN ?>"><?= $pagesN ?></h1>
			<?php } ?>

		</form>

	<?php }?>

</section>

{% end content %}
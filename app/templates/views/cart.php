{% extends main %}

{% block main %}

<!-- Slider -->
<section id="slider" class="bgr-c">

	<div class="bgr" <?= background_image('/app/templates/images/cart/bgr.png') ?>></div>

	<h1 id="title">CA<span class="txt-c1">RR</span>ELLO</h1>

</section>

<!-- Flow bar -->
<?php cart_flow($view) ?>

<!-- Page content -->
<div id="body" class="content-wrap">
	<?php include_once('cart/'.$page.'.php') ?>
</div>

</section>

{% end main %}
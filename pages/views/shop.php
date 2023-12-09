{% block main %}

<section id="head">
	<div id="bgr" class="bgr" <?= background_image('bgr.jpg', $view) ?>></div>

	<div id="title-box" class="txt-cen cenY rel pado5">
		<h1 id="title" class="marb4 txt-c1">Prodott<span style="letter-spacing: 0;">i</span></h1>
		
		<div id="srch-pan" class="mwid650">

			<form method="GET" autocomplete="off" class="grid">

				<div class="srch_cell left">
					<input type="text" name="search" class="srch_inp" placeholder="Cerca un prodotto" value="<?= $_GET['search'] ?? '';?>" maxlength="30" onfocus="$(this).parents('.srch_row').addClass('focus');" onblur="$(this).parents('.srch_row').removeClass('focus');" autocomplete="off">
				</div>

				<div class="srch_cell right">
					<button type="submit" class="srch_btn mbtn">
						<span class="icon bgr-f" <?= icon_svg('actions/search')?>></span>
					</button>
				</div>

			</form>

		</div>
	</div>

	<a href="#body" class="nav-arr pos-br bot wht scroll"></a>
</section>


<div id="body" class="content-wrap padt3">

	<div class="shop-title-box">
		<h2 class="shop-title txt-light">I NOSTRI <span class="txt-c3 txt-bold">PRODOTTI</span></h2>
		<div id="anch1" class="anchor"></div>
	</div>
	
	<?php element_shop() ?>

</div>

{% end main %}
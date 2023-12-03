<!-- Items -->
<div id="items">

	<form id="add-to-cart-form" method="POST">

		<input type="hidden" name="itemID" value="">

		<button type="submit" name="add-to-cart" class="hide"></button>
		
	</form>
	
	<div id="items-bgr" class="bgr bot" <?= background_image('items/bgr.jpg', $view) ?>></div>
	<div class="overlay bgr"></div>

	<div class="content-wrap">

		<div class="title-box">

			<h1 id="items-title" class="txt-c1 txt-upp">
				<span class="load ld-rig ld-del3 inlb" style="font-size: .8em;">I Nostri</span><br>
				<span class="load ld-lef inlb">Prodotti</span>
			</h1>

			<div class="title-line inlb bgr-c1 load ld-lef ld-del3"></div>

			<p id="items-stitle" class="txt-c3 txt-ita load ld-rig ld-del6">Integratori, tinture, oli e molto altro</p>

		</div>

		<div id="items-grid" class="grid5 grid4-1440w grid3-768w grid2-480w marv2 bgr-f">

			<?php
				item_grid($res_items);
			?>
			
		</div>

		<div class="load ld-lef ld-del3">
			<a href="<?= html_link('shop') ?>" class="mbtn">
				<span class="bgr bgr-c3"></span>
				<span class="btn-icon bgr-f" <?= icon_svg('ecommerce/cart');?>></span>
				<span class="btn-txt">Tutti i prodotti</span>
			</a>
		</div>
	</div>
</div>
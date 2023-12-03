
<header class="gallery <?= $theme_color ?> <?= $theme_floating ? 'floating' : '' ?>">

	<div id="h-pan">

		<div id="h-bgr" class="bgr"></div>

		<!-- Left bar -->
		<div id="h-nav-lef" class="h-nav-bar inlb txt-lef al-mid <?php if ($view->name == 'home') echo 'load ld-rig' ?>">

			<!-- Logo -->
			<?php if ($h_comp['logo']) { ?>

				<a href="/" id="h-logo"></a>

			<?php } ?>

			<!-- Search bar -->
			<?php if ($h_comp['srch-bar']) { ?>

				<form id="h-srch" class="inlb" method="GET" onClick="$('#h-srch-inp').focus();" action="<?= html_link('shop') ?>#body">

					<input type="checkbox" id="h-srch-cbx" class="hide">

					<label for="h-srch-cbx" id="h-srch-ico-box" class="br-c1 al-mid">
					
						<div class="bgr bgr-c1"></div>

						<div id="h-srch-ico" class="icon">
							<?= icon_embed('actions/search') ?>
						</div>

					</label>

					<div id="h-srch-inp-box">
						<input type="text" id="h-srch-inp" name="search" placeholder="Cerca un prodotto o tag">
					</div>

					<div class="h-name-box inlb al-mid hide">
						<h1 class="h-name txt-upp desk"><a href="/"><?= $h_name ?></a></h1>
						<h1 class="h-name txt-upp mob"><a href="/"><?= $h_name_m ?></a></h1>
					</div>

					<div id="h-search-logo">
						<img src="<?= $theme_color == 'light' ? file_url(__LOGO__.'logo_bro.png') : file_url(__LOGO__.'logo_wht.png') ?>">
					</div>

				</form>

			<?php } ?>

			<!-- Name -->
			<?php if ($h_comp['name-bar']) { ?>
				<div clas="h-name-box" class="inlb">
					<h1 class="h-name txt-upp desk">
						<?php if (!$h_closed) { ?>
							<a href="<?= $user->admin ? sysData('ad') : '/' ?>"><?= $h_name ?></a>
						<?php } else { ?>
							<span class="disabled"><?= $h_name ?></span>
						<?php } ?>
					</h1>
					<h1 class="h-name txt-upp mob">
						<?php if (!$h_closed) { ?>
							<a href="<?= $user->admin ? sysData('ad') : '/' ?>"><?= $h_name ?></a>
						<?php } else { ?>
							<span class="disabled"><?= $h_name ?></span>
						<?php } ?>
					</h1>
				</div>
			<?php } ?>
		</div>

		<!-- Central bar -->
		<div id="h-nav-cen" class="h-nav-bar inlb txt-cen al-mid"></div>

		<!-- Right bar -->
		<div id="h-nav-rig" class="h-nav-bar inlb txt-rig al-mid">

			<!-- Links -->
			<?php if (!$h_comp['force-mob']) { ?>

				<div class="h-nav-box desk inlb al-mid txt-wht <?php if ($view->name == 'home') echo 'load ld-lef' ?>">

					<?php foreach ($h_links as $h_link) {

						$h_valid = true;

						//check logged filter
						if (isset($h_link['logged'])) {

							if ($h_link['logged'] && !$user->id) $h_valid = false;
							else if (!$h_link['logged'] && $user->id) $h_valid = false;
						}

						//check seller filter
						if (isset($h_link['seller'])) {

							if ($h_link['seller'] && !$user->is_seller()) $h_valid = false;
							else if (!$h_link['seller'] && $user->is_seller()) $h_valid = false;
						}

						//check admin filter
						if (isset($h_link['admin']) && !$user->admin) $h_valid = false;

						//check manager filter
						if (isset($h_link['manager']) && !manager()) $h_valid = false;

						//check cart filter
						if (isset($h_link['cart']) && !order_count()) $h_valid = false;

						//check mobile filter
						if (isset($h_link['mob']) && $h_link['mob']) $h_valid = false;

						if ($h_valid) { ?>

							<div
								class="h-link <?= isset($h_link['megamenu']) ? 'megamenu-open' : '' ?>"
								
								<?php if (isset($h_link['megamenu'])) { ?>
									data-megamenu="<?= $h_link['megamenu'] ?>"
								<?php } ?>
							>

								<p class="h-link-txt <?php if (isset($h_link['loc']) && $view->loc == $h_link['loc']) echo 'active' ?> <?= isset($h_link['url']) ? '' : 'disabled' ?>">

									<?php if (isset($h_link['url'])) { ?>
										<a href="<?= $h_link['url'] ?>">
									<?php } ?>

										<?= $h_link['title'] ?>

									<?php if (isset($h_link['url'])) { ?>
										</a>
									<?php } ?>

								</p>

								<?php if (isset($h_link['drop'])) { ?>

									<div class="h-drop <?= count($h_drop[$h_link['drop']]) > 5 ? 'big' : '' ?>">

										<?php foreach ($h_drop[$h_link['drop']] as $h_drop_link) { ?>

											<p class="h-drop-link txt-c1 txt-09rem txt-wht-h"><a href="<?= $h_drop_link[1] ?>"><?= $h_drop_link[0] ?></a></p>								
										<?php } ?>

									</div>

								<?php } ?>

							</div>
					<?php }} ?>

					<!-- Favorites icon -->
					<?php if ($h_comp['wishlist']) { ?>
						<a id="h-wish" class="wish h-link al-mid" href="/wishlist"></a>
					<?php } ?>

					<!-- Cart icon -->
					<a href="<?= html_link('cart') ?>" id="h-cart" class="bag h-link al-mid">
						
						<div class="icon bgr" <?= icon_svg('ecommerce/bag') ?>></div>
					
						<?php if (order_count()) { ?>
							<h1 id="h-cart-num"><?= order_count() ?></h1>
						<?php } ?>

					</a>

				</div>
			<?php } ?>

			<!-- Login bar -->
			<?php if ($h_comp['login']) { ?>

				<div id="h-log-box" class="inlb al-mid <?= $h_comp['force-mob'] ? 'hide' : 'desk' ?> <?php if ($view->name == 'home') echo 'load ld-lef' ?>">

					<?php if ($user->id) { ?>

						<a href="<?= $h_log_in[1] ?>"><p class="h-log-txt br-c1-h txt-upp main"><?= $h_log_in[0] ?></p></a>

					<?php } else { ?>

						<a href="<?= $h_log_out[1] ?>"><p class="h-log-txt br-c1-h txt-upp main"><?= $h_log_out[0] ?></p></a>
						
					<?php } ?>

				</div>
				
			<?php } ?>

			<!-- Mobile menu -->
			<div id="h-mob-pan" class="txt-rig <?php if (!$h_comp['force-mob']) echo 'mob' ?>">

				<!-- Cart icon mobile -->
				<?php if (order_count()) { ?>
					<a href="<?= html_link('cart') ?>" id="h-cart" class="h-link al-mid <?= $view->name == 'home' ? 'load ld-lef ld-del3' : '' ?>">
						<div class="icon bgr" <?= icon_svg('ecommerce/bag') ?>></div>
						<h1 id="h-cart-num"><?= order_count() ?></h1>
					</a>
				<?php } ?>
				
				<!-- Mobile icon -->
				<input type="checkbox" id="h-cbxM" class="hide" onclick="$('#h-pan').toggleClass('h-open');">

				<label id="h-icoM-box" for="h-cbxM" class="<?php if ($view->name == 'home') echo 'load ld-lef' ?>">
					<div id="h-icoM-line1" class="h-icoM-line"><div class="h-icoM-rot"></div></div>
					<div id="h-icoM-line2" class="h-icoM-line"><div class="h-icoM-rot"></div></div>
					<div id="h-icoM-line3" class="h-icoM-line"><div class="h-icoM-rot"></div></div>
				</label>

				<!-- Mobile box -->
				<div id="h-navM" class="txt-lef <?php if (!$h_comp['force-mob']) echo 'mob' ?>" onClick="$('#h-cbxM').click();">

					<div id="h-navM-bgr" class="bgr"></div>

					<div id="h-contM">

						<!-- Links -->
						<?php foreach ($h_links as $h_link) {

							$h_valid = true;

							//check logged filter
							if (isset($h_link['logged'])) {

								if ($h_link['logged'] && !$user->id) $h_valid = false;
								else if (!$h_link['logged'] && $user->id) $h_valid = false;
							}

							//check seller filter
							if (isset($h_link['seller'])) {

								if ($h_link['seller'] && !$user->is_seller()) $h_valid = false;
								else if (!$h_link['seller'] && $user->is_seller()) $h_valid = false;
							}

							//check admin filter
							if (isset($h_link['admin']) && !$user->admin) $h_valid = false;

							//check manager filter
							if (isset($h_link['manager']) && !manager()) $h_valid = false;

							//check cart filter
							if (isset($h_link['cart']) && !order_count()) $h_valid = false;

							//check mobile filter
							if (isset($h_link['mob']) && !$h_link['mob']) $h_valid = false;

							if ($h_valid) { ?>

								<label class="h-linkM">

									<input type="checkbox" class="h-dropM-cbx hide">

									<a <?php if (!isset($h_link['drop']) && !isset($h_link['megamenu'])) echo 'href="'.$h_link['url'].'"' ?>>

										<p class="h-linkM-txt txt-upp txt-bold">
										
											<span class="h-linkM-bgr bgr bgr-c1"></span>

											<?=
												$h_link['title'];
												if (isset($h_link['drop']) || isset($h_link['megamenu'])) echo ' <span class="h-dropM-ico">&#x25BC;</span>';
											?>
										
										</p>

									</a>


									<?php if (isset($h_link['drop'])) { ?>

										<div class="h-dropM">

											<?php foreach ($h_drop[$h_link['drop']] as $h_drop_link) { ?>

												<p class="h-dropM-link txt-wht-h bgr-c3-h">
													<a href="<?= $h_drop_link[1] ?>">
														<?= $h_drop_link[0] ?>
													</a>
												</p>

											<?php } ?>
										</div>

									<?php } ?>


									<?php if (isset($h_link['megamenu'])) { ?>

										<div class="h-dropM">

											<?php foreach ($header['megamenus'][$h_link['megamenu']]['categories'] as $h_drop_link) { ?>

												<p class="h-dropM-link txt-wht-h bgr-c3-h">
													<a href="<?= $h_drop_link['link'] ?>">
														<?= $h_drop_link['title'] ?>
													</a>
												</p>

											<?php } ?>
										</div>

									<?php } ?>

								</label>
						<?php }} ?>

						<!-- Line -->
						<div class="h-lineM bgr-c1"></div>

						<!-- Language -->
						<?php if ($h_comp['lang-bar']) { ?>
							<p id="h-lang" class="txt-wht"><a href="?lang=it">IT</a> <span style="padding: 0 1rem">|</span> <a href="?lang=en">EN</a></p>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>

		<!-- Mega menus -->
		<?php foreach ($h_links as $h_link) {

			$h_valid = true;

			//check logged filter
			if (isset($h_link['logged'])) {

				if ($h_link['logged'] && !$user->id) $h_valid = false;
				else if (!$h_link['logged'] && $user->id) $h_valid = false;
			}

			//check seller filter
			if (isset($h_link['seller'])) {

				if ($h_link['seller'] && !$user->is_seller()) $h_valid = false;
				else if (!$h_link['seller'] && $user->is_seller()) $h_valid = false;
			}

			//check admin filter
			if (isset($h_link['admin']) && !$user->admin) $h_valid = false;

			//check manager filter
			if (isset($h_link['manager']) && !manager()) $h_valid = false;

			//check cart filter
			if (isset($h_link['cart']) && !order_count()) $h_valid = false;

			//check mobile filter
			if (isset($h_link['mob']) && $h_link['mob']) $h_valid = false;


			if ($h_valid && isset($h_link['megamenu'])) { ?>

				<div
					id="megamenu-<?= $h_link['megamenu'] ?>"
					class="megamenu <?= isset($header['megamenus'][$h_link['megamenu']]['link']) ? 'no-padding' : '' ?>"
					style="--menu-size: <?= $header['megamenus'][$h_link['megamenu']]['size'] ?>"
					>

					<div class="wrap">

						<?php foreach ($header['megamenus'][$h_link['megamenu']]['categories'] as $h_category) { ?>

							<div class="category">

								<!-- Title -->
								<h3>
									<a href="<?= $h_category['link'] ?>">
										<?= $h_category['title'] ?>
									</a>
								</h3>

								<!-- Link list -->
								<div class="links">

									<?php foreach ($h_category['list'] as $h_slink) { ?>

										<p>
											<a class="inlb txt-c2-h" href="<?= $h_slink[1] ?>">
												<?= $h_slink[0] ?>
											</a>
										</p>

									<?php } ?>

								</div>
							</div>

						<?php } ?>

					</div>

					<?php if (isset($header['megamenus'][$h_link['megamenu']]['link'])) { ?>

						<p class="general-link">
							<a href="<?= $header['megamenus'][$h_link['megamenu']]['link'][1] ?>">
								<?= $header['megamenus'][$h_link['megamenu']]['link'][0] ?>
							</a>
						</p>

					<?php } ?>

				</div>

			<?php } ?>
		<?php } ?>

	</div>

	<!-- Cookies -->
	<?php if ($h_comp['privacy'] && !isset($_SESSION['cookW']) && !isset($_COOKIE['cookW']) && (!$user->id || !$user->privacy)) { ?>
		<div id="h-cook" class="hide">
			<script>
				$(document).ready(function() {
					$('#h-cook-btn').click(function() {
						$('#h-cook').hide();

						$.ajax({
						  method: "POST",
						  url: "/system/general/php/ajax/cookies.php",
						  data: {aaa: "true"}
						})
					});
				});
			</script>

			<p id="h-cook-txt">Questo sito utilizza cookie a scopo di analisi. Continuando a navigare questo sito, accetti tale utilizzo.</p>
			<button type="button" id="h-cook-btn">OK</button>
		</div>
	<?php } ?>
</header>
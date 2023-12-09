<?php

function cart_flow($view) {

	$cart = $view->get('cart');
	$cart_flow = $view->get('cart_flow');
	$loc = $view->get('loc');

	$step = $cart->step;
	$stepN = count($cart_flow);

	?>

	<section id="flow">

		<div class="content-wrap">

			<?php foreach ($cart_flow as $key => $flow) { ?>

				<div class="flow-step" style="width: calc(100% / <?= $stepN;?>);">

					<!-- Circle -->
					<div class="flow-box_top">

						<!-- Left line -->
						<?php if ($key > 1) { ?>
							<div class="line left <?php if ($key <= $step) echo 'active';?>"></div>
						<?php } ?>


						<!-- Number -->
						<a
							<?= $key <= $step && $loc != $key ? 'href="'.html_link('cart?step='.$key).'"' : '' ?>
							class="
								circle
								<?= $key == $step ? 'active' : '' ?>
								<?= $key < $step ? 'completed' : '' ?>
								<?= $key == $loc ? 'this' : '' ?>
							">

							<?php if ($key < $step) { ?>

								<div class="icon <?= $key == $loc ? 'bgr-wht' : 'bgr-c1' ?> cen" <?= icon_svg('form/correct') ?>></div>

							<?php } else { ?>

								<p class="flow-numb"><?= $key ?></p>

							<?php } ?>

						</a>

						<!-- Right line -->
						<?php if ($key < $stepN) { ?>
							<div class="line right <?= $key < $step ? 'active' : '' ?>"></div>
						<?php } ?>

					</div>

					<!-- Title -->
					<div class="flow-box_bot <?= $key <= $step ? 'active' : '' ?>">
						<p class="flow-txt"><?= $flow[0] ?></p>
					</div>

				</div>

			<?php } ?>

		</div>

	</section>

<?php }
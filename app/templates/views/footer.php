<footer>
	<div>
		<div id="foot-bgr" class="bgr" <?= background_image('/app/templates/images/footer/bgr.png') ?>></div>

		<div id="footer-wrap" class="content-wrap padv5">

			<div id="footer-body" class="grid">

				<div id="foot-logo" class="img cont" <?= background_image('/app/templates/images/footer/logo.png') ?>></div>

				<div id="foot-col-pan" class="grid3 grid2-1024w al-top">

					<?php foreach ($f_cols as $f_col) { ?>

						<div class="footer-col">

							<p class="footer-title txt-wht txt-bold txt-upp"><?= $f_col['title'] ?></p>

							<?php foreach ($f_col['links'] as $f_link) {

								if (isset($f_link[1])) { ?>
									
									<p class="footer-link">
										<a href="<?= html_link($f_link[1]) ?>"><?= $f_link[0] ?></a>
									</p>

								<?php } else { ?>

									<p class="footer-link"><?= $f_link[0] ?></p>

								<?php }

							} ?>

						</div>

					<?php } ?>

					<?php if ($f_comp['contacts']) { ?>
						<div id="footer-cont" class="footer-col">
							<p class="footer-title txt-wht txt-bold txt-upp">Contatti</p>

							<div class="flex gap1">

								<?php if (in_array('call', $f_contacts)) { ?>
									<a href="<?= sysData('cont-tel-link') ?>">
										<div class="footer-soc-icon icon-box">
											<?= icon_embed('contacts/call') ?>
										</div>
									</a>
								<?php } ?>

								<?php if (in_array('inst', $f_contacts)) { ?>
									<a href="<?= sysData('cont-inst-link') ?>">
										<div class="footer-soc-icon icon-box">
											<?= icon_embed('contacts/instagram') ?>											
										</div>
									</a>
								<?php } ?>

								<?php if (in_array('fb', $f_contacts)) { ?>
									<a href="<?= sysData('cont-fb-link') ?>">
										<div class="footer-soc-icon icon-box">
											<?= icon_embed('contacts/facebook') ?>
										</div>
									</a>
								<?php } ?>

								<?php if (in_array('mail', $f_contacts)) { ?>
									<a href="<?= sysData('cont-mail-link') ?>">
										<div class="footer-soc-icon icon-box">
											<?= icon_embed('contacts/mail') ?>
										</div>
									</a>
								<?php } ?>

								<?php if (in_array('addr', $f_contacts)) { ?>
									<p class="txt-wht mart1" style="opacity: .6;"><?= sysData('cont-addr') ?></p>
								<?php } ?>

							</div>
						</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>

	<div id="footer-notes" class="txt-cen">
		<p id="footer-notes-txt">
			Copyright © <?= getdate()['year'] ?> <?= sysData('name_full') ?>. P. IVA <?= sysData('VAT') ?>.<br>
			Sito web realizzato da <a class="txt-wht-h" href="mailto:ismaele.tuffanelli@gmail.com">Ismaele Tuffanelli</a>
		</p>
	</div>
</footer>
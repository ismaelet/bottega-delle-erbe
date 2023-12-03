<section id="blog" class="padb3">

	<div id="blog-wrap" class="wrap">

		<div class="pado2">

			<div class="grid3 grid2-1024w grid1-480w grid-pad2 grid-pad1-768w al-top">

				<?php $i = 0; while ($post = $res_posts->fetch_assoc()) { $i++; ?>
				
					<a href="<?= html_link('blog/post?id='.$post['id']) ?>" class="grid-ele blog-post-box bgr-f6 load ld-bot ld-del<?= $i ?>">

						<div id="blog-post<?= $post['id'] ?>" class="blog-post">

							<div class="blog-img">
								<img src="<?= file_url('/uploads/blog/'.$post['id'].'_m.jpg') ?>" loading="lazy" class="img-cover cont">
							</div>

							<div class="blog-cont">

								<p class="blog-title txt-spa1 txt-2rem txt-bold txt-c1 padb1"><?= $post['title'] ?></p>
								
								<p class="blog-txt"><?= strlen($post['text']) > 200 ? substr($post['text'], 0, 197).'...' : $post['text'] ?></p>

								<p class="blog-link mart1 txt-1rem txt-c5">Leggi tutto</p>

							</div>

						</div>

					</a>

				<?php } ?>
			</div>

			<div class="txt-cen">
				<a href="<?= html_link('blog') ?>" class="sbtn txt-def load ld-bot ld-del2">Tutte le novità</a>
			</div>

		</div>

	</div>

	<a href="#slider" class="scroll-top">
		<div class="icon-box pad1">
			<?= icon_embed('navigation/arrow1-top') ?>
		</div>
	</a>

</section>
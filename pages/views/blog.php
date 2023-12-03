{% block main %}

<!-- Slider -->
<div id="slider" class="grid">

	<div id="bgr" class="bgr" <?= background_image('bgr.jpg', $view) ?>></div>

		<h1 id="title">Novità</h1>

	</div>

</div>

<!-- Posts -->
<section id="posts" class="bgr-f6 padt7 padb5">

	<div class="content-wrap">

		<!-- Posts -->
		<div class="posts grid4 grid3-1440w grid2-768w grid1-480w al-top">

			<?php $i = 0; while ($post = $posts->fetch_assoc()) { $i++; ?>

				<a href="<?= html_link('blog/post?id='.$post['id']) ?>" class="post" data-id="<?= $i ?>">

					<div class="box bgr-f">

						<!-- Image -->
						<div class="image">
							<img src="<?= file_url('/uploads/blog/'.$post['id'].'_m.jpg') ?>" alt="" loading="lazy" class="img-cover <?= $post['cover'] ? 'cover' : 'contain' ?>">
						</div>

						<!-- Body -->
						<div class="body txt-cen">

							<!-- Title -->
							<h1 class="title txt-25px txt-sbold"><?= $post['title'] ?></h1>
							<p class="data txt-09rem txt-a"><?= str_replace('-', ' &middot; ', date('d-m-Y', strtotime($post['time']))) ?></p>

							<!-- Text -->
							<p class="text txt-09rem mart2"><?= $post['text'] ?></p>

							<!-- Read more -->
							<div class="txt-cen">
								<p class="more txt-c2-h br-c2-h mart1 brb1 br-a brb-dashed inlb">Continua a leggere</p>
							</div>

						</div>

					</div>

				</a>

			<?php } ?>

		</div>

		<!-- Pages -->
		<section id="pages" class="txt-cen mart5">

			<?php for ($i = 1; $i <= $pageN; $i++) { ?>

				<a href="?page=<?= $i ?>">
					<h1 class="page txt-12rem inlb <?= $page == $i ? 'active' : '' ?>"><?= $i ?></h1>
				</a>

			<?php } ?>

		</section>
		
	</div>
	
</section>

{% end main %}
{% block main %}

<!-- Slider -->
<div id="slider" class="grid">

	<div id="bgr" class="bgr" <?= background_image('bgr.jpg', $view) ?>></div>

		<h1 id="title">Novità</h1>

	</div>

</div>

<!-- Content -->
<section id="body" class="content-wrap padt7 padb5">

	<div id="content-head" class="grid content-grid">

		<div id="post-head">

			<h1 class="title txt-3rem txt-sbold txt-c1"><?= $post['title'] ?></h1>
			<p class="date mart2 txt-ls1 txt-a"><?= str_replace('-', ' &middot; ', date('d-m-Y', strtotime($post['time']))) ?></p>

		</div>


		<div class="more-posts desk1024">
			
			<h1 class="title txt-upp txt-c1 txt-13rem txt-bold txt-cen">Altre Novità</h1>
		
		</div>

	</div>

	<div id="content-body" class="grid content-grid al-top mart3">

		<div id="post-body">

			<div class="txt-cen">
				<img src="<?= file_url('/uploads/blog/'.$post['id'].'.jpg') ?>" alt="" class="image marb2">
			</div>

			<p class="text txt-1rem txt-lh2"><?= $post['text'] ?></p>

			<div class="txt-cen mart2">
				<a href="<?= html_link('blog') ?>" class="sbtn txt-def desk1024">Tutte le novità</a>
			</div>

		</div>


		<div class="more-posts">
			
			<h1 class="title txt-c1 txt-sbold txt-cen mob1024 marb4">Altre Novità</h1>
			
			<div class="posts grid">
				<?php while ($post = $postsM->fetch_assoc()) { ?>

					<a href="<?= html_link('blog/post?id='.$post['id']) ?>" class="post grid">

						<div class="img image <?= $post['cover'] ? 'cover' : 'contain' ?>" <?= background_image('/uploads/blog/'.$post['id'].'_m.jpg') ?>></div>

						<div class="data">
							<h1 class="txt-sbold txt-13rem"><?= $post['title'] ?></h1>
							<p class="date mart1 txt-c"><?= date('d - m - Y', strtotime($post['time'])) ?></p>
						</div>

					</a>

				<?php } ?>
			</div>

		</div>

	</div>
	
</section>

{% end main %}
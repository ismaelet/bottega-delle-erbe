{% block main %}

<!-- Slider -->
<div id="slider" class="grid">

	<div id="bgr" class="bgr" <?= background_image('bgr.jpg', $view) ?>></div>

		<h1 id="title">Corsi</h1>

	</div>

</div>

<!-- Courses -->
<section id="courses" class="padt10 padb5">

	<div class="content-wrap">

		<?php if ($courses->num_rows) { ?>
	
			<?php while ($course = $courses->fetch_assoc()) { ?>

				<div class="course bgr-f grid">

					<div class="image">
						<img src="<?= file_url('/uploads/courses/'.$course['id'].'_m.jpg') ?>" alt="" loading="lazy" class="img-cover">
					</div>

					<div class="data">
						<h2 class="title txt-sbold txt-c1"><?= $course['title'] ?></h2>
						<p class="text mart2 txt-1rem txt-lh2 txt-line2"><?= $course['text'] ?></p>

						<p class="schedule txt-09rem txt-lh2 txt-c2"><?= $course['schedule'] ?></p>

					</div>

					<a href="<?= html_link('courses/course?id='.$course['id']) ?>" class="explore">
						<p class="txt-upp txt-c3 txt-1rem txt-sbold inlb">Scopri il corso</p>
						<div class="icon bgr-c3 inlb" <?= icon_svg('navigation/arrow1-right') ?>></div>
					</a>
					
				</div>

			<?php } ?>

		<?php } else { ?>

			<div class="empty">
				<p class="txt-1rem txt-cen txt-ls1">Al momento non ci sono corsi attivi.</p>
			</div>

		<?php } ?>

	</div>

</section>

{% end main %}
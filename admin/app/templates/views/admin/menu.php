<section id="menu">

	<div class="floating">

		<div class="over-auto hei100">

			<div class="categories">

				<!-- Title -->
				<h1 class="title txt-line txt-25px txt-med"><?= sysData('name') ?></h1>

				<!-- Public sections -->
				<div class="group marb1">

					<p class="stitle txt-09rem txt-bold">Sito web</p>

					<div class="category static">

						<!-- Title box -->
						<a href="<?= sysData('public-domain') ?>" class="title-box grid">
							
							<div class="img cont inlb" <?= background_image(__ICON__.'pages/home.svg') ?>></div>
							
							<p class="title txt-line inlb">Homepage</p>
							
						</a>

					</div>

				</div>

				<!-- Admin sections -->
				<div class="group">

					<p class="stitle txt-09rem txt-bold">Amministrazione</p>

					<?php foreach ($menu['categories'] as $category) { ?>

						<!-- Menu category -->
						<div class="category <?= $category['checked'] ? 'active' : '' ?>">

							<!-- Title box -->
							<div class="title-box grid">
								
								<div class="img cont inlb" <?= background_image('/app/resources/icons/navigation/'.$category['slug'].'.svg') ?>></div>
								
								<p class="title txt-line inlb"><?= $category['name'] ?></p>
								
							</div>

							<!-- Dropdown -->
							<div class="ddown" style="--count: <?= $category['count'] ?>">

								<?php foreach ($category['sections'] as $section) { ?>

									<a href="<?= $section['url'] ?>">
										<p class="link <?= $section['checked'] ? 'active' : '' ?>">
											<?= $section['name'] ?>
										</p>
									</a>

								<?php } ?>

							</div>
						</div>

					<?php } ?>

				</div>

			</div>

		</div>

		<!-- Mobile open menu icon -->
		<div id="open-menu" class="mob cen">
			<div class="icon cen" <?= icon_svg('navigation/arrow1-right') ?>></div>
		</div>

	</div>

</section>
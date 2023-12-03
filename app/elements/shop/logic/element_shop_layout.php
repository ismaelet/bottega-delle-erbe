<?php

function view_shop($shop) {?>

	<div id="store">

		<?php if ($shop->id) {?><input type="hidden" name="id" value="<?= $shop->id ?>"><?php } ?>
		<input type="hidden" id="js-itemN" value="<?= $shop->resN ?>">

		<div id="store-tbl">

			<form method="GET" action="#body" autocomplete="off" id="filter-sec">

				<input type="hidden" name="sort" value="<?= $shop->sort ?>">

				<p id="filter-text" onclick="$(this).toggleClass('open'); $(this).next().toggleClass('open');">Filtra la ricerca<span class="search-ddown-ico"></span></p>

				<div id="search-sec">
					<div id="search-mob-box" class="padb3">
						<div class="marb2">
							<div id="search-inp-box" class="gallery">
								<input type="text" id="search-inp" class="inlb" name="search" value="<?= $shop->search ?>" placeholder="Cerca un prodotto" maxlength="30" onfocus="$(this).parent().addClass('focus');" onblur="$(this).parent().removeClass('focus');" autocomplete="off">
								<button type="submit" id="search-ico" class="inlb clickable"></button>
							</div>
						</div>

						<div class="srch-box">

							<p class="srch-title">Filtra</p>

							<!-- Uses -->
							<div>
								<input type="checkbox" id="uses-cbx" class="hide category-cbx" <?= empty($_GET['use']) ? '' : 'checked' ?>>

								<label class="category-title-box" for="uses-cbx">
									<p class="category-title">
										<span class="category-ico bgr-2 icon" <?= icon_svg('navigation/arrow1-down') ?>></span>
										<span class="">Esigenze</span>
									</p>
								</label>	                            

								<div class="category-ddown">

									<?php

										$res = DB::select('tag FROM items_uses ORDER BY id ASC');

										while ($row = $res->fetch_assoc()) {

											$uses = new Uses($row['tag']) ?>

											<label>

												<input type="checkbox" class="use-cbx category-cbx hide" name="use" value="<?= $uses->tag ?>" <?php if ($shop->use == $uses->tag) echo 'checked' ?>>

												<p class="type-title"><?= $uses->name ?></p>

											</label>

									<?php } ?>

								</div>

								<button type="submit" id="filter-use" class="hide"></button>

							</div>

							<!-- Types -->
							<div>
								<input type="checkbox" id="category-cbx" class="hide category-cbx" <?= empty($_GET['type']) ? '' : 'checked' ?>>

								<label class="category-title-box" for="category-cbx">
									<p class="category-title">
										<span class="category-ico bgr-2 icon" <?= icon_svg('navigation/arrow1-down') ?>></span>
										<span class="">Tipologie</span>
									</p>
								</label>	                            

								<div class="category-ddown">
									<?php
										$res = DB::select('tag FROM items_types WHERE category="product" ORDER BY ID ASC');

										while ($row = $res->fetch_assoc()) {

											$type = new Type($row['tag']) ?>

											<label>
												
												<input type="checkbox" class="type-cbx category-cbx hide" name="type" value="<?= $type->tag ?>" <?php if ($shop->type == $type->tag) echo 'checked'?>>

												<p class="type-title"><?= $type->names ?></p>

											</label>
									<?php } ?>
								</div>

								<button type="submit" id="filter-type" class="hide"></button>

							</div>

						</div>

						<!-- Tags -->
						<?php /*if (!$shop->id) {
							$res_tags = DB::select('tag FROM sys_tags WHERE hide=0 ORDER BY count DESC LIMIT 20') ?>

							<div class="srch-box gallery">
								<p class="srch-title padt3 marb5px">Tag popolari</p>
								<?php while ($row_tags = $res_tags->fetch_assoc()) {?>
									<label>
										<input type="checkbox" name="tag" value="<?= $row_tags['tag'] ?>" class="tag-cbx hide" <?php if ($row_tags['tag'] == $shop->tag) echo 'checked' ?>>
										<p class="tag"><?= $row_tags['tag'] ?></p>
									</label>
								<?php } ?>

								<button type="submit" id="filter_tag" class="hide"></button>

								<?php if ($shop->tag) {?>
									<p id="remove-filter-tag" class="remove-filter clickable padt1">
										<span class="txt-bold txt-blk">x</span>
										rimuovi filtro
									</p>
								<?php } ?>
							</div>
						<?php }*/?>

						<?php if ($shop->type || $shop->search) { ?>
						
							<p id="remove-filter-tag" class="remove-filter clickable padt1">
								<span class="txt-bold txt-blk">x</span>
								rimuovi filtro
							</p>

						<?php } ?>

					</div>
				</div>
			</form>

			<section id="items-sec" class="padb3">

				<div id="items" class="items_panel">

					<?php if ($shop->edit) {?>
						<button type="submit" id="hide-items" name="hide-items" class="hide"></button>
					<?php } ?>

					<div id="load"></div>

					<form action="#body" method="GET" id="sort_box">

						<input type="hidden" name="type" value="<?= $shop->type ?>">

						<label>
							<input type="checkbox" class="sort-cbx hide" name="sort" value="new" <?php if ($shop->sort == 'new') echo 'checked' ?>>
							<p class="sort_txt clickable">Nuovi</p>
						</label>

						<p class="sort_txt">&middot;</p>

						<label>
							<input type="checkbox" class="sort-cbx hide" name="sort" value="pop" <?php if ($shop->sort == 'pop') echo 'checked' ?>>
							<p class="sort_txt clickable">Popolari</p>
						</label>

						<button type="submit" id="sort" class="hide"></button>

					</form>

					<div class="grid5 grid4-1440w grid3-1024w grid2-480w">

						<?php
							item_grid($shop->seed);
						?>

					</div>

					<?php if (!$shop->seed->num_rows) {?>
						<p id="store-empty">
							<span class="store-empty-ico bgr-2" <?= icon_svg('form/warning') ?>></span><br><br>
							Nessun articolo trovato
						</p>
					<?php } ?>

					<!-- Pages -->
					<form method="GET" action="#body" id="pages">

						<input type="hidden" name="type" value="<?= $shop->type ?>">
						<input type="hidden" name="sort" value="<?= $shop->sort ?>">

						<?php

							$pageN = ceil($shop->resN / $shop->size);

							if ($pageN > 1) {

								$base = $shop->page - 2;

								if ($base < 1) $base = 1;

								$top = $base + 4;

								if ($top > $pageN) {
									$top = $pageN;
									$i = $top - 4;
								} else $i = $base;

								if ($i < 1) $i = 1;

								?>

								<div id="page-box" class="txt-cen mart3">

									<input type="hidden" id="page-inp" name="page" value="<?= $shop->page ?>">

									<?php if ($i > 1) {?><p class="page_txt disabled">...</p><?php } ?>

									<?php while ($i <= $top) {?>
										<h1 class="page_txt clickable <?php if ($i == $shop->page) echo 'select disabled' ?>" data-page="<?= $i ?>"><?= $i ?></h1>
									<?php $i++;} ?>

									<?php if ($pageN > $top) {?><p class="page_txt disabled">...</p><?php } ?>

									<button type="submit" id="page-btn" class="hide"></button>

								</div>
						<?php } ?>

					</form>

				</div>
			</section>
		</div>
	</form>
<?php }
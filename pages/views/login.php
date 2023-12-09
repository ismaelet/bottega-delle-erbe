{% block main %}

<div class="bgr bgr-c2"></div>

<div id="bgr" class="bgr" <?= background_image('bgr.jpg', $view) ?>></div>

<div id="form-pan" class="inlb">
	<div class="form-tbl">
		<div class="form-cell">
			<form id="form" class="form" method="POST">
				
				<div class="form-head">
					<h1 class="form-title txt-c1 load ld-top">Logi<span style="letter-spacing: 0">n</span></h1>
				</div>
				
				<div class="form-body">
					<input type="text" name="username" id="username" class="inp load ld-lef" placeholder="Username">
					<input type="password" name="password" id="password" class="inp load ld-rig" placeholder="Password">
					<?php if ($error == 'user_bad') {?><p class="inp err load ld-rig">Dati di accesso errati</p><?php }?>

					<a href="/login/recover"><p class="txt txt-c1 load ld-lef">Hai dimenticato la password?</p></a>
				</div>
				
				<div class="form-foot">                        
					<div class="load ld-rig">
						<button type="submit" name="submit" id="submit" class="mbtn wid100">Log In</button>
					</div>
									
					<div class="load ld-lef hide">
						<button type="submit" id="fb-btn" name="fb-btn" class="mbtn bgr-c3 bgr-c2-h">
							<input type="hidden" id="fbID" name="fbID" value="0">
							<span class="soc-ico fb-ico wht"></span>
							<span style="vertical-align: middle;">Facebook Login</span>
						</button>
					</div>
										
					<a href="/login/register" class="block load ld-rig hide">
						<button type="button" class="sbtn wid100 br-c1 br-c5-h txt-c1">Registrati</button>
					</a>
				</div>
			</form>
		</div>
	</div>
</div>

{% end main %}
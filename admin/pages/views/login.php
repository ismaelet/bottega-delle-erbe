{% block main %}

<div class="form-tbl">
	<div class="form-cell">
		<form id="form" class="form" method="POST">
			<div class="form-head">
				<h1 class="form-title">Login</h1>
			</div>
			
			<div class="form-body">
				<input type="text" name="username" id="username" class="inp" placeholder="Username">
				<input type="password" name="password" id="password" class="inp" placeholder="Password">
				<?php if ($error == 'error_wrong') {?><p class="inp err">Dati di accesso errati</p><?php }?>
			</div>
			
			<div class="form-foot">

				<button type="submit" name="submit" id="submit" class="mbtn bgr-c1">Log In</button>

			</div>
		</form>
	</div>
</div>

{% end main %}
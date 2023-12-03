{% block main %}

<div class="form-tbl">
	<div class="form-cell">
		<form id="form" class="form" method="POST">
			<div class="form-head">
				<h1 class="form-title">Logout</h1>
			</div>
			
			<div class="form-body">
				<p class="padv1">Sei sicuro di voler uscire?</p>
			</div>
			
			<div class="form-foot">

				<button type="submit" name="submit" class="mbtn">Log Out</button>
				<a href="/"><button type="button" class="sbtn">Indietro</button></a>

			</div>
		</form>
	</div>
</div>

{% end main %}
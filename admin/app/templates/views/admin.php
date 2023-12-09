{% extends main %}

{% block main %}

<!-- Navigation bar -->
<?php require_once('admin/menu.php') ?>

<!-- Body -->
<section id="body">

	<div id="wrap">

		{% place content %}
		{% end content %}

	</div>

</section>

{% end main %}
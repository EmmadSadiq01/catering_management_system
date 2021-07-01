<div class="wrapper d-flex align-items-stretch">
	<nav id="sidebar" class="active">
		<h1><a href="index.html" class="logo">V.E.S</a></h1>
		<ul class="list-unstyled components mb-5">
			<li class="nav-home">
				<a href="index.php?page=home"><span class="fa fa-home"></span> Home</a>
			</li>
			<li>
				<a href="#"><span class="fa fa-user"></span> vendors</a>
			</li>
			<li class="nav-orders">
				<a href="index.php?page=orders"><span class="fas fa-book"></span> Order</a>
			</li>
			<li class="nav-meal">
				<a href="index.php?page=meal"><span class="fas fa-book"></span> Meal</a>
			</li>
		</ul>

		<div class="footer">
			<p>
				Copyright &copy;
				<script>
					document.write(new Date().getFullYear());
				</script> All rights reserved | <i class="icon-heart" aria-hidden="true"></i> by <a href="https://ves-engr.com" target="_blank">V.E.S </a>
			</p>
		</div>
	</nav>

	<script>
		$('.nav-<?php echo isset($_GET['page']) ? $_GET['page'] : '' ?>').addClass('active');
	</script>
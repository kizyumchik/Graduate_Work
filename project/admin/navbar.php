
<style>
	.collapse a{
		text-indent:10px;
	}
	nav#sidebar{
		background: url(assets/uploads/<?php echo $_SESSION['system']['cover_img'] ?>) !important
	}
</style>

<nav id="sidebar" class='mx-lt-5 bg-dark' >
		
		<div class="sidebar-list">
				<a href="index.php?page=home" class="nav-item nav-home"><span class='icon-field'><i class="fa fa-home"></i></span> Главная</a>
				<a href="index.php?page=schedule" class="nav-item nav-schedule"><span class='icon-field'><i class="fa fa-calendar-day"></i></span> Расписание</a>
				<a href="index.php?page=courses" class="nav-item nav-courses"><span class='icon-field'><i class="fa fa-list"></i></span> Список групп</a>
				<a href="index.php?page=teachers" class="nav-item nav-courses"><span class='icon-field'><i class="fa fa-list"></i></span> Список преподавателей</a>
				<a href="index.php?page=subjects" class="nav-item nav-subjects"><span class='icon-field'><i class="fa fa-book"></i></span> Список дисциплин</a>
				<a href="index.php?page=faculty" class="nav-item nav-faculty"><span class='icon-field'><i class="fa fa-user-tie"></i></span> Список факультетов</a>
				<a href="index.php?page=chair" class="nav-item nav-faculty"><span class='icon-field'><i class="fa fa-user-tie"></i></span> Список кафедр</a>
				<a href="index.php?page=audiences" class="nav-item nav-courses"><span class='icon-field'><i class="fa fa-list"></i></span> Список аудиторий</a>
				<?php if($_SESSION['login_type'] == 1): ?>
				<a href="index.php?page=users" class="nav-item nav-users"><span class='icon-field'><i class="fa fa-users"></i></span> Пользователи</a>
			<?php endif; ?>
		</div>

</nav>
<script>
	$('.nav_collapse').click(function(){
		console.log($(this).attr('href'))
		$($(this).attr('href')).collapse()
	})
	$('.nav-<?php echo isset($_GET['page']) ? $_GET['page'] : '' ?>').addClass('active')
</script>

<?php include 'db_connect.php' ?>
<?php
if(isset($_GET['id'])){
	$qry = $conn->query("SELECT *,concat(title,', ',dean) as name FROM faculty where id=".$_GET['id'])->fetch_array();
	foreach($qry as $k =>$v){
		$$k = $v;
	}
}

?>
<div class="container-fluid">
	<p>Название: <b><?php echo ucwords($title) ?></b></p>
	<p>Декан: <b><?php echo ucwords($dean) ?></b></p>
	<p>Email: </i> <b><?php echo $email ?></b></p>
	<p>Контакты: </i> <b><?php echo $contact ?></b></p>
	<p>Адрес: </i> <b><?php echo $address ?></b></p>
	<hr class="divider">
</div>
<div class="modal-footer display">
	<div class="row">
		<div class="col-md-12">
			<button class="btn float-right btn-secondary" type="button" data-dismiss="modal">Закрыть</button>
		</div>
	</div>
</div>
<style>
	p{
		margin:unset;
	}
	#uni_modal .modal-footer{
		display: none;
	}
	#uni_modal .modal-footer.display {
		display: block;
	}
</style>
<script>
	
</script>
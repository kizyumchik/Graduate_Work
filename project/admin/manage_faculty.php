<?php include 'db_connect.php' ?>
<?php
if(isset($_GET['id'])){
	$qry = $conn->query("SELECT * FROM faculty where id=".$_GET['id'])->fetch_array();
	foreach($qry as $k =>$v){
		$$k = $v;
	}
}

?>
<div class="container-fluid">
	<form action="" id="manage-faculty">
		<div id="msg"></div>
				<input type="hidden" name="id" value="<?php echo isset($_GET['id']) ? $_GET['id']:'' ?>" class="form-control">
		<div class="row form-group">
			<div class="col-md-4">
						<label class="control-label">Код</label>
						<input type="text" name="id_no" class="form-control" value="<?php echo isset($id_no) ? $id_no:'' ?>" >
					</div>
		</div>
		<div class="row form-group">
			<div class="col-md-4">
				<label class="control-label">Название</label>
				<input type="text" name="lastname" class="form-control" value="<?php echo isset($title) ? $title:'' ?>" required>
			</div>
			<div class="col-md-4">
				<label class="control-label">Декан</label>
				<input type="text" name="firstname" class="form-control" value="<?php echo isset($dean) ? $dean:'' ?>" required>
			</div>
		</div>
		<div class="row form-group">
			<div class="col-md-4">
				<label class="control-label">Email</label>
				<input type="email" name="email" class="form-control" value="<?php echo isset($email) ? $email:'' ?>" required>
			</div>
			<div class="col-md-4">
				<label class="control-label">Контакты</label>
				<input type="text" name="contact" class="form-control" value="<?php echo isset($contact) ? $contact:'' ?>" required>
			</div>
		</div>
		<div class="row form-group">
			<div class="col-md-12">
				<label class="control-label">Адрес</label>
				<textarea name="address" class="form-control"><?php echo isset($address) ? $address : '' ?></textarea>
			</div>
		</div>
	</form>
</div>

<script>
	$('#manage-faculty').submit(function(e){
		e.preventDefault()
		start_load()
		$.ajax({
			url:'ajax.php?action=save_faculty',
			method:'POST',
			data:$(this).serialize(),
			success:function(resp){
				if(resp == 1){
					alert_toast("Данные успешно сохранены.",'success')
					setTimeout(function(){
						location.reload()
					},1000)
				}else if(resp == 2){
					$('#msg').html('<div class="alert alert-danger">Такой код уже существует.</div>')
					end_load();
				}
			}
		})
	})
</script>
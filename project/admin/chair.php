<?php include('db_connect.php');?>

<div class="container-fluid">
	
	<div class="col-lg-12">
		<div class="row">
			<!-- FORM Panel -->
			<div class="col-md-4">
			<form action="" id="manage-chair">
				<div class="card">
					<div class="card-header">
						    Форма для заполнения дисциплины
				  	</div>
					<div class="card-body">
							<div class="form-group">
								<label class="control-label">Название</label>
								<input type="text" class="form-control" name="chair">
							</div>
							<div class="form-group">
								<label class="control-label">Описание</label>
								<textarea class="form-control" cols="30" rows='3' name="description"></textarea>
							</div>
					</div>
							
					<div class="card-footer">
						<div class="row">
							<div class="col-md-12">
								<button class="btn btn-sm btn-primary col-sm-3 offset-md-3"> Сохранить</button>
								<button class="btn btn-sm btn-default col-sm-3" type="button" onclick="_reset()"> Очистить</button>
							</div>
						</div>
					</div>
				</div>
			</form>
			</div>
			<!-- FORM Panel -->

			<!-- Table Panel -->
			<div class="col-md-8">
				<div class="card">
					<div class="card-header">
						<b>Список кафедр</b>
					</div>
					<div class="card-body">
						<table class="table table-bordered table-hover">
							<thead>
								<tr>
									<th class="text-center">#</th>
									<th class="text-center">Кафедра</th>
									<th class="text-center">Действия</th>
								</tr>
							</thead>
							<tbody>
								<?php 
								$i = 1;
								$chair = $conn->query("SELECT * FROM chairs order by id asc");
								while($row=$chair->fetch_assoc()):
								?>
								<tr>
									<td class="text-center"><?php echo $i++ ?></td>
									<td class="">
										<p>Кафедра: <b><?php echo $row['chair'] ?></b></p>
										<p>Описание: <small><b><?php echo $row['description'] ?></b></small></p>
										
									</td>
									<td class="text-center">
										<button class="btn btn-sm btn-primary edit_chair" type="button" data-id="<?php echo $row['id'] ?>" data-chair="<?php echo $row['chair'] ?>" data-description="<?php echo $row['description'] ?>" >Редактировать</button>
										<button class="btn btn-sm btn-danger delete_chair" type="button" data-id="<?php echo $row['id'] ?>">Удалить</button>
									</td>
								</tr>
								<?php endwhile; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<!-- Table Panel -->
		</div>
	</div>	

</div>
<style>
	
	td{
		vertical-align: middle !important;
	}
</style>
<script>
	function _reset(){
		$('#manage-chair').get(0).reset()
		$('#manage-chair input,#manage-chair textarea').val('')
	}
	$('#manage-chair').submit(function(e){
		e.preventDefault()
		start_load()
		$.ajax({
			url:'ajax.php?action=save_chair',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success:function(resp){
				if(resp==1){
					alert_toast("Данные успешно добавлены.",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
				else if(resp==2){
					alert_toast("Данные успешно обновлены.",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
			}
		})
	})
	$('.edit_chair').click(function(){
		start_load()
		var cat = $('#manage-chair')
		cat.get(0).reset()
		cat.find("[name='id']").val($(this).attr('data-id'))
		cat.find("[name='chair']").val($(this).attr('data-chair'))
		cat.find("[name='description']").val($(this).attr('data-description'))
		end_load()
	})
	$('.delete_chair').click(function(){
		_conf("Вы уверены, что хотите удалить эту запись?","delete_chair",[$(this).attr('data-id')])
	})
	function delete_chair($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_chair',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				if(resp==1){
					alert_toast("Данные успешно удалены.",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
			}
		})
	}
	$('table').dataTable()
</script>
<?php include('db_connect.php');?>

<div class="container-fluid">
	
	<div class="col-lg-12">
		<div class="row">
			<!-- FORM Panel -->
			<div class="col-md-4">
			<form action="" id="manage-audience">
				<div class="card">
					<div class="card-header">
						    Форма для заполнения аудитории
				  	</div>
					<div class="card-body">
							<input type="hidden" name="id">
							<div class="form-group">
								<label class="control-label">Номер аудитории</label>
								<input type="text" class="form-control" name="audience">
							</div>
							<div class="form-group">
								<label class="control-label">Тип аудитории</label>
							<select name="type" id="type" class="custom-select select2">
								<option value=""></option>
							<?php 
								$audience = $conn->query("SELECT *,type as name FROM type_audience order by id asc");
								while($row= $audience->fetch_array()):
							?>
								<option value="<?php echo $row['id'] ?>"><?php echo ucwords($row['name']) ?></option>
							<?php endwhile; ?>
							</select>
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
						<b>Список преподавателей</b>
					</div>
					<div class="card-body">
						<table class="table table-bordered table-hover">
							<thead>
								<tr>
									<th class="text-center">#</th>
									<th class="text-center">Аудитория</th>
									<th class="text-center">Тип</th>
									<th class="text-center">Действия</th>
								</tr>
							</thead>
							<tbody>
								<?php 
								$i = 1;
								$audience = $conn->query("SELECT * FROM audiences order by id asc");
								while($row=$audience->fetch_assoc()):
								?>
								<tr>
									<td class="text-center"><?php echo $i++ ?></td>
									<td class="">
										<p><b><?php echo $row['audience'] ?></b></p>
									</td>
									<td class="">
										<p><small><b><?php echo $row['type'] ?></b></small></p>
									</td>
									<td class="text-center">
										<button class="btn btn-sm btn-primary edit_audience" type="button" data-id="<?php echo $row['id'] ?>" data-audience="<?php echo $row['audience'] ?>" data-type="<?php echo $row['type'] ?>" >Редактировать</button>
										<button class="btn btn-sm btn-danger delete_audience" type="button" data-id="<?php echo $row['id'] ?>">Удалить</button>
									</td>
								</tr>
								<option value="<?php echo $row['id'] ?>" <?php echo isset($faculty_id) && $faculty_id == $row['id'] ? 'selected' : '' ?>><?php echo ucwords($row['name']) ?></option>
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
		$('#manage-audience').get(0).reset()
		$('#manage-audience input,#manage-audience textarea').val('')
	}
	$('#manage-audience').submit(function(e){
		e.preventDefault()
		start_load()
		$.ajax({
			url:'ajax.php?action=save_audience',
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
	$('.edit_audience').click(function(){
		start_load()
		var cat = $('#manage-audience')
		cat.get(0).reset()
		cat.find("[name='id']").val($(this).attr('data-id'))
		cat.find("[name='audience']").val($(this).attr('data-audience'))
		cat.find("[name='type']").val($(this).attr('data-type'))
		end_load()
	})
	$('.delete_audience').click(function(){
		_conf("Вы уверены, что хотите удалить эту запись?","delete_audience",[$(this).attr('data-id')])
	})
	function delete_audience($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_audience',
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
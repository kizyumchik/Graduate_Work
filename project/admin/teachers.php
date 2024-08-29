<?php include('db_connect.php');?>

<div class="container-fluid">
	
	<div class="col-lg-12">
		<div class="row">
			<!-- FORM Panel -->
			<div class="col-md-4">
			<form action="" id="manage-teacher">
				<div class="card">
					<div class="card-header">
						    Форма для заполнения преподавателя
				  	</div>
					<div class="card-body">
							<input type="hidden" name="id">
							<div class="form-group">
								<label class="control-label">ФИО</label>
								<input type="text" class="form-control" name="teacher">
							</div>
							<div class="form-group">
								<label class="control-label">Кафедра</label>
							<select name="chair" id="chair" class="custom-select select2">
								<option value=""></option>
							<?php 
								$chair = $conn->query("SELECT *,chair as name FROM chairs order by id asc");
								while($row= $chair->fetch_array()):
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
									<th class="text-center">Преподаватель</th>
									<th class="text-center">Кафедра</th>
									<th class="text-center">Действия</th>
								</tr>
							</thead>
							<tbody>
								<?php 
								$i = 1;
								$teacher = $conn->query("SELECT * FROM teachers order by id asc");
								while($row=$teacher->fetch_assoc()):
								?>
								<tr>
									<td class="text-center"><?php echo $i++ ?></td>
									<td class="">
										<p><b><?php echo $row['teacher'] ?></b></p>
									</td>
									<td class="">
										<p><small><b><?php echo $row['chair'] ?></b></small></p>
									</td>
									<td class="text-center">
										<button class="btn btn-sm btn-primary edit_teacher" type="button" data-id="<?php echo $row['id'] ?>" data-teacher="<?php echo $row['teacher'] ?>" data-chair="<?php echo $row['chair'] ?>" >Редактировать</button>
										<button class="btn btn-sm btn-danger delete_teacher" type="button" data-id="<?php echo $row['id'] ?>">Удалить</button>
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
		$('#manage-teacher').get(0).reset()
		$('#manage-teacher input,#manage-teacher textarea').val('')
	}
	$('#manage-teacher').submit(function(e){
		e.preventDefault()
		start_load()
		$.ajax({
			url:'ajax.php?action=save_teacher',
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
	$('.edit_teacher').click(function(){
		start_load()
		var cat = $('#manage-teacher')
		cat.get(0).reset()
		cat.find("[name='id']").val($(this).attr('data-id'))
		cat.find("[name='teacher']").val($(this).attr('data-teacher'))
		cat.find("[name='chair']").val($(this).attr('data-chair'))
		end_load()
	})
	$('.delete_teacher').click(function(){
		_conf("Вы уверены, что хотите удалить эту запись?","delete_teacher",[$(this).attr('data-id')])
	})
	function delete_teacher($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_teacher',
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
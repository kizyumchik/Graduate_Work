<?php include('db_connect.php');?>

<div class="container-fluid">
	
	<div class="col-lg-12">
		<div class="row">
			<!-- FORM Panel -->
			<div class="col-md-4">
			<form action="" id="manage-subject">
				<div class="card">
					<div class="card-header">
						    Форма для заполнения дисциплины
				  	</div>
					<div class="card-body">
							<input type="hidden" name="id">
							<div class="form-group">
								<label class="control-label">Название</label>
								<input type="text" class="form-control" name="subject">
							</div>
							<div class="form-group">
								<label class="control-label">Описание</label>
								<textarea class="form-control" cols="30" rows='3' name="description"></textarea>
							</div>
							<div class="form-group">
								<label class="control-label">Преподаватель</label>
								<select name="teacher" id="teacher" class="custom-select select2">
								<option value=""></option>
							<?php 
								$teacher = $conn->query("SELECT *,teacher as name FROM teachers order by id asc");
								while($row= $teacher->fetch_array()):
							?>
								<option value="<?php echo $row['id'] ?>" <?php echo isset($teacher) && $teacher == $row['id'] ? 'selected' : '' ?>><?php echo ucwords($row['name']) ?></option>
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
						<b>Список дисциплин</b>
					</div>
					<div class="card-body">
						<table class="table table-bordered table-hover">
							<thead>
								<tr>
									<th class="text-center">#</th>
									<th class="text-center">Дисциплины</th>
									<th class="text-center">Преподаватель</th>
									<th class="text-center">Действия</th>
								</tr>
							</thead>
							<tbody>
								<?php 
								$i = 1;
								$subject = $conn->query("SELECT * FROM subjects order by id asc");
								while($row=$subject->fetch_assoc()):
								?>
								<tr>
									<td class="text-center"><?php echo $i++ ?></td>
									<td class="">
										<p>Дисциплина: <b><?php echo $row['subject'] ?></b></p>
										<p>Описание: <small><b><?php echo $row['description'] ?></b></small></p>
										
									</td>
									<td class="">
										<b><?php echo $row['teacher'] ?></b></p>
									</td>
									<td class="text-center">
										<button class="btn btn-sm btn-primary edit_subject" type="button" data-id="<?php echo $row['id'] ?>" data-subject="<?php echo $row['subject'] ?>" data-description="<?php echo $row['description'] ?>" data-teacher="<?php echo $row['teacher'] ?>" >Редактировать</button>
										<button class="btn btn-sm btn-danger delete_subject" type="button" data-id="<?php echo $row['id'] ?>">Удалить</button>
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
		$('#manage-subject').get(0).reset()
		$('#manage-subject input,#manage-subject textarea').val('')
	}
	$('#manage-subject').submit(function(e){
		e.preventDefault()
		start_load()
		$.ajax({
			url:'ajax.php?action=save_subject',
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
	$('.edit_subject').click(function(){
		start_load()
		var cat = $('#manage-subject')
		cat.get(0).reset()
		cat.find("[name='id']").val($(this).attr('data-id'))
		cat.find("[name='subject']").val($(this).attr('data-subject'))
		cat.find("[name='description']").val($(this).attr('data-description'))
		cat.find("[name='teacher']").val($(this).attr('data-teacher'))
		end_load()
	})
	$('.delete_subject').click(function(){
		_conf("Вы уверены, что хотите удалить эту запись?","delete_subject",[$(this).attr('data-id')])
	})
	function delete_subject($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_subject',
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
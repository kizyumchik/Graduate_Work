<?php include('db_connect.php');?>

<div class="container-fluid">
	
	<div class="col-lg-12">
		<div class="row">
			<!-- FORM Panel -->
			<div class="col-md-4">
			<form action="" id="manage-course">
				<div class="card">
					<div class="card-header">
						    Форма для заполнения группы
				  	</div>
					<div class="card-body">
							<input type="hidden" name="id">
							<div class="form-group">
								<label class="control-label">Группа</label>
								<input type="text" class="form-control" name="course">
							</div>
							<div class="form-group">
								<label class="control-label">Факультет</label>
							<select name="faculty" id="faculty" class="custom-select select2">
								<option value=""></option>
							<?php 
								$faculty = $conn->query("SELECT *,title as name FROM faculty order by title asc");
								while($row= $faculty->fetch_array()):
							?>
								<option value="<?php echo $row['id'] ?>" <?php echo isset($faculty) && $faculty == $row['id'] ? 'selected' : '' ?>><?php echo ucwords($row['name']) ?></option>
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
						<b>Список групп</b>
					</div>
					<div class="card-body">
						<table class="table table-bordered table-hover">
							<thead>
								<tr>
									<th class="text-center">#</th>
									<th class="text-center">Группа</th>
									<th class="text-center">Факультет</th>
									<th class="text-center">Действия</th>
								</tr>
							</thead>
							<tbody>
								<?php 
								$i = 1;
								$course = $conn->query("SELECT * FROM courses order by id asc");
								while($row=$course->fetch_assoc()):
								?>
								<tr>
									<td class="text-center"><?php echo $i++ ?></td>
									<td class="">
										<p><b><?php echo $row['course'] ?></b></p>
									</t>
									<td class="">
										<p><small><b><?php echo $row['faculty'] ?></b></small></p>
									</td>
									<td class="text-center">
										<button class="btn btn-sm btn-primary edit_course" type="button" data-id="<?php echo $row['id'] ?>" data-course="<?php echo $row['course'] ?>" data-faculty="<?php echo $row['faculty'] ?>" >Редактировать</button>
										<button class="btn btn-sm btn-danger delete_course" type="button" data-id="<?php echo $row['id'] ?>">Удалить</button>
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
		$('#manage-course').get(0).reset()
		$('#manage-course input,#manage-course textarea').val('')
	}
	$('#manage-course').submit(function(e){
		e.preventDefault()
		start_load()
		$.ajax({
			url:'ajax.php?action=save_course',
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
	$('.edit_course').click(function(){
		start_load()
		var cat = $('#manage-course')
		cat.get(0).reset()
		cat.find("[name='id']").val($(this).attr('data-id'))
		cat.find("[name='course']").val($(this).attr('data-course'))
		cat.find("[name='faculty']").val($(this).attr('data-faculty'))
		end_load()
	})
	$('.delete_course').click(function(){
		_conf("Вы уверены, что хотите удалить эту запись?","delete_course",[$(this).attr('data-id')])
	})
	function delete_course($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_course',
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
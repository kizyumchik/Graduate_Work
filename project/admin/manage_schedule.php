<?php include 'db_connect.php' ?>
<?php
if(isset($_GET['id'])){
$qry = $conn->query("SELECT * FROM schedules where id= ".$_GET['id']);
foreach($qry->fetch_array() as $k => $val){
	$$k=$val;
}
if(!empty($repeating_data)){
$rdata= json_decode($repeating_data);
	foreach($rdata as $k => $v){
		 $$k = $v;
	}
	$dow_arr = isset($dow) ? explode(',',$dow) : '';
	// var_dump($start);
}
}
?>
<style>
	
	
</style>
<div class="container-fluid">
	<form action="" id="manage-schedule">
		<input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
		<div class="col-lg-16">
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label for="" class="control-label">Факультет</label>
						<select name="faculty_id" id="" class="custom-select select2">
							<option value=""></option>
						<?php 
							$faculty = $conn->query("SELECT *,title as name FROM faculty order by title asc");
							while($row= $faculty->fetch_array()):
						?>
							<option value="<?php echo $row['id'] ?>" <?php echo isset($faculty_id) && $faculty_id == $row['id'] ? 'selected' : '' ?>><?php echo ucwords($row['name']) ?></option>
						<?php endwhile; ?>
						</select>
					</div>
					<div class="form-group">
						<label for="" class="control-label">Группа</label>
						<select name="course_id" id="" class="custom-select select2">
							<option value=""></option>
						<?php 
							$course = $conn->query("SELECT *,course as name FROM courses order by course asc");
							while($row= $course->fetch_array()):
						?>
							<option value="<?php echo $row['id'] ?>" <?php echo isset($course_id) && $course_id == $row['id'] ? 'selected' : '' ?>><?php echo ucwords($row['name']) ?></option>
						<?php endwhile; ?>
						</select>
					</div>
					<div class="form-group">
						<label for="" class="control-label">Дисциплина</label>
						<select name="subject" id="" class="custom-select select2">
							<option value=""></option>
						<?php 
							$subject1 = $conn->query("SELECT *,subject as name FROM subjects order by subject asc");
							while($row= $subject1->fetch_array()):
						?>
							<option value="<?php echo $row['id'] ?>" <?php echo isset($subject) && $subject == $row['id'] ? 'selected' : '' ?>><?php echo ucwords($row['name']) ?></option>
						<?php endwhile; ?>
						</select>
					</div>
					<div class="form-group">
						<label for="" class="control-label">Тип расписания</label>
						<select name="schedule_type" id="" class="custom-select">
							<option value="1" <?php echo isset($schedule_type) && $schedule_type == 1 ? 'selected' : ''  ?>>Пары</option>
							<option value="2" <?php echo isset($schedule_type) && $schedule_type == 2 ? 'selected' : ''  ?>>Экзамены</option>
						</select>
					</div>
					<div class="form-group">
						<label for="" class="control-label">Преподаватель</label>
						<select name="teacher" id="" class="custom-select select2">
							<option value=""></option>
						<?php 
							$teacher1 = $conn->query("SELECT *,teacher as name FROM teachers order by teacher asc");
							while($row= $teacher1->fetch_array()):
						?>
							<option value="<?php echo $row['id'] ?>" <?php echo isset($teacher) && $teacher == $row['id'] ? 'selected' : '' ?>><?php echo ucwords($row['name']) ?></option>
						<?php endwhile; ?>
						</select>
					</div>
					<div class="form-group">
						<label for="" class="control-label">Аудитория</label>
						<select name="audience" id="" class="custom-select select2">
							<option value=""></option>
						<?php 
							$audience1 = $conn->query("SELECT *,concat(audience, ' (',LEFT(type, 1), ')') as name FROM audiences order by concat(audience, '(',LEFT(type, 1), ')') asc");
							while($row= $audience1->fetch_array()):
						?>
							<option value="<?php echo $row['id'] ?>" <?php echo isset($audience) && $audience == $row['id'] ? 'selected' : '' ?>><?php echo ucwords($row['name']) ?></option>
						<?php endwhile; ?>
						</select>
					</div>
					<div class="form-group">
						<div class="form-check">
						  <input class="form-check-input" type="checkbox" value="1" id="is_repeating" name="is_repeating" <?php echo isset($is_repeating) && $is_repeating != 1 ? '' : 'checked' ?>>
						  <label class="form-check-label" for="type">
						   	Еженедельное расписание
						  </label>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group for-repeating">
						<label for="dow" class="control-label">Дни недели</label>
						<select name="dow[]" id="dow" class="custom-select select2" multiple="multiple">
							<?php 
							$dow = array("Понедельник","Вторник","Среда","Четверг","Пятница","Суббота");
							for($i = 0; $i < 7;$i++):
							?>
							<option value="<?php echo $i ?>"  <?php echo isset($dow_arr) && in_array($i,$dow_arr) ? 'selected' : ''  ?>><?php echo $dow[$i] ?></option>
						<?php endfor; ?>
						</select>
					</div>
					<div class="form-group for-repeating">
						<label for="" class="control-label">Месяц начала</label>
						<input type="month" name="month_from" id="month_from" class="form-control" value="<?php echo isset($start) ? date("Y-m",strtotime($start)) : '' ?>">
					</div>
					<div class="form-group for-repeating">
						<label for="" class="control-label">Месяц окончания</label>
						<input type="month" name="month_to" id="month_to" class="form-control" value="<?php echo isset($end) ? date("Y-m",strtotime($end)) : '' ?>">
					</div>
					<div class="form-group for-nonrepeating" style="display: none">
						<label for="" class="control-label">Дата проведения</label>
						<input type="date" name="schedule_date" id="schedule_date" class="form-control" value="<?php echo isset($schedule_date) ? $schedule_date : '' ?>">
					</div>
					<div class="form-group">
						<label for="" class="control-label">Пара (время)</label>
						<select name="time" id="" class="custom-select select2">
							<option value=""></option>
						<?php 
							$time1 = $conn->query("SELECT *,concat(id,' (',time_start,' - ',time_end,')') as name FROM study_time order by concat(time_start, ' - ',time_end) asc");
							while($row= $time1->fetch_array()):
						?>
							<<option value="<?php echo $row['id'] ?>" <?php echo isset($time) && $time == $row['id'] ? 'selected' : '' ?>><?php echo ucwords($row['name']) ?></option>
						<?php endwhile; ?>
						</select>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>
<div class="imgF" style="display: none " id="img-clone">
			<span class="rem badge badge-primary" onclick="rem_func($(this))"><i class="fa fa-times"></i></span>
	</div>
<script>
	if('<?php echo isset($id) ? 1 : 0 ?>' == 1){
		if($('#is_repeating').prop('checked') == true){
			$('.for-repeating').show()
			$('.for-nonrepeating').hide()
		}else{
			$('.for-repeating').hide()
			$('.for-nonrepeating').show()
		}
	}
	$('#is_repeating').change(function(){
		if($(this).prop('checked') == true){
			$('.for-repeating').show()
			$('.for-nonrepeating').hide()
		}else{
			$('.for-repeating').hide()
			$('.for-nonrepeating').show()
		}
	})
	$('.select2').select2({
		placeholder:'Выберите здесь',
		width:'100%'
	})
	$('#manage-schedule').submit(function(e){
		e.preventDefault()
		start_load()
		$('#msg').html('')
		$.ajax({
			url:'ajax.php?action=save_schedule',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success:function(resp){
				if(resp==1){
					alert_toast("Данные успешно сохранены.",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
				
			}
		})
	})
	
</script>
<?php include 'db_connect.php' ?>
<?php
if(isset($_GET['id'])){
	$qry = $conn->query("SELECT * FROM schedules where id=".$_GET['id'])->fetch_array();
	foreach($qry as $k =>$v){
		$$k = $v;
	}
}

?>
<div class="container-fluid">
	<p>Группа: <b>
	<?php 
		$result = $conn->query("SELECT c.course as name FROM schedules s, courses c where c.id = s.course_id and s.id=".$_GET['id']);
		while ($row = $result->fetch_assoc()) {
			echo $row['name'];
		}
	?>
	</b></p>
	<p>Дисциплина: </i><b>
	<?php 
		$result = $conn->query("SELECT sb.subject as name FROM schedules s, subjects sb where sb.id = s.subject and s.id=".$_GET['id']);
		while ($row = $result->fetch_assoc()) {
			echo $row['name'];
		}
	?>		
	</b></p>
	<p>Преподаватель: <b>
	<?php 
		$result = $conn->query("SELECT t.teacher as name FROM schedules s, teachers t where t.id = s.teacher and s.id=".$_GET['id']);
		while ($row = $result->fetch_assoc()) {
			echo $row['name'];
		}
	?>	
	</b></p>
	<p>Время: </i> <b>
	<?php 
		$result = $conn->query("SELECT *,concat(s.time,' (',st.time_start,' - ',st.time_end,')') as name FROM schedules s, study_time st WHERE st.id = s.time and s.id=".$_GET['id']);
		while ($row = $result->fetch_assoc()) {
			echo $row['name'];
		}
	?>
	</b></p>
	<p>Аудитория: </i> <b>
	<?php 
		$result = $conn->query("SELECT *,concat(a.audience, ' (',LEFT(t.type, 1), ')') as name FROM schedules s, audiences a, type_audience t WHERE a.type = t.id and a.id = s.audience and s.id=".$_GET['id']);
		while ($row = $result->fetch_assoc()) {
			echo $row['name'];
		}
	?>		
	</b></p>
	<hr class="divider">
</div>
<div class="modal-footer display">
	<div class="row">
		<div class="col-md-12">
			<button class="btn float-right btn-secondary" type="button" data-dismiss="modal">Закрыть</button>
			<button class="btn float-right btn-danger mr-2" type="button" id="delete_schedule">Удалить</button>
			<button class="btn float-right btn-primary mr-2" type="button" id="edit">Редактировать</button>
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
	$('#edit').click(function(){
		uni_modal('Редактирование расписания','manage_schedule.php?id=<?php echo $id ?>','mid-large')
	})
	$('#delete_schedule').click(function(){
		_conf("Вы уверены, что хотите удалить эту запись?","delete_schedule",[$(this).attr('data-id')])
	})
	
	function delete_schedule($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_schedule',
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
</script>
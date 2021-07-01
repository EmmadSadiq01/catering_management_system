<?php 
include 'db_connect.php'; 
if(isset($_GET['id'])){
	$qry = $conn->query("SELECT * FROM maintenance where id = ".$_GET['id'])->fetch_array();
	foreach($qry as $k => $v){
		$$k = $v;
	}
}
?>

<div class="container-fluid">
	<form id='employee_frm'>
		<div class="form-group">
			<label>Description:</label>
			<input type="hidden" name="id" value="<?php echo isset($id) ? $id : "" ?>" />
			<input type="hidden" name="maintenance_no" value="<?php echo isset($maintenance_no) ? $maintenance_no : "" ?>" />
			<textarea name="description" required cols="30" rows="2" class="form-control" ><?php echo isset($description) ? $description : "" ?></textarea>
		</div>
		<div class="form-group">
			<label>Priority:</label>
			<select name="priority" id="priority" class="custom-select">
				<option value="1" <?php echo isset($priority) && $priority == 1 ? 'selected': '' ?>>Low</option>
				<option value="2" <?php echo isset($priority) && $priority == 2 ? 'selected': '' ?>>Medium</option>
				<option value="3" <?php echo isset($priority) && $priority == 3 ? 'selected': '' ?>>High</option>
			</select>
			</div>
	</form>
</div>
<script>
	$(document).ready(function(){
		$('.select2').select2({
			placeholder:"Please Select Here",
			width:"100%"
		})
		$('#employee_frm').submit(function(e){
				e.preventDefault()
				start_load();
			$.ajax({
				
				url:'ajax.php?action=generate_cashout_maintenance',
				method:"POST",
				data:$(this).serialize(),
				error:err=>console.log(),
				success:function(resp){
						if(resp == 1){
							alert_toast("Cashout's data successfully saved","success");
								setTimeout(function(){
								location.reload();

							},1000)
						}
				}
			})
		})
	})
</script>
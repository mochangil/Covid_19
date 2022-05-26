<html>
<?php
	require_once 'dbconfig_covid.php'	
?>
<style>
	table {
		width: 100%;
		border: 1px solid #444444;
		border-collapse: collapse;
	}
	th, td {
		border: 1px solid #444444;
	}
</style>
	<body>
		<?php
			$sql="select count(*) as num_patient from PATIENTINFO;";
        	$result = mysqli_query($link, $sql);
        	$data=mysqli_fetch_assoc($result);
        	print "<tr>";
        	print "Patient info table (Currently " . $data['num_patient'] . " patient in database)";
        	print "</tr>";
		?>
	<h3>Hospital Id를 선택하세요</h3>

	<form method="POST" action="./hospital.php">
		<?php
			$i = 0;
			print "<select name=\"hid\">";
			print "<option value=\"All\">All</option>";
			$sql = "select distinct hospital_id from patientinfo order by patient_id asc";
			$res = mysqli_query($link, $sql);
			while($row = mysqli_fetch_assoc($res)){
				$i = $i + 1;
				foreach($row as $key => $val){
					print "<option value=" . $val . ">" . $val . "</option>";
				}
			}
			?>
	</select>
	<input type="submit" value = "load">
	<?php
		if(!isset($_POST['hid']))
		{
			$value=NULL;
			$message="";
		}	
		else{
			$value=$_POST['hid'];
			if($value=="All")
			{
				$value=null;
				$sql="select count(*) as cnt from patientinfo;";
				$result = mysqli_query($link, $sql);
				$data = mysqli_fetch_assoc($result);	
				$message = "";
			}else{
				$sql="select count(*) as cnt from patientinfo where hospital_id = \"$value\";";
				$result = mysqli_query($link, $sql);
				$data = mysqli_fetch_assoc($result);	
				$message = "Patient info table (Currently ".$data['cnt'].") patient in database who in Hospital Id: ".$value;
			}
		}
		?>
		<p>
			<h3><?php echo $message ?></h3>
	</p>
	<table class="table table-striped">
	
		<tr>
			<th>Patient_ID</th>
			<th>Sex</th>
			<th>Age</th>
			<th>Country</th>
			<th>province</th>
			<th>City</th>
			<th>infection_Casee</th>
			<th>Infected_by</th>
			<th>contact_number</th>
			<th>symptom_onset_date</th>
			<th>confirmed_date</th>
			<th>released_date</th>
			<th>deceased_date</th>
			<th>State</th>
			<th>Hospital_id</th>
		</tr>
		
		<?php
		//latitude,위도=y, longitude,경도=x
		//hid 마다의 x좌표, y좌표, name을 배열에 저장.
		$sql = "select hospital_id,hospital_name,hospital_latitude,hospital_longitude from hospital;";
		$result = mysqli_query($link,$sql);
		while($row = mysqli_fetch_assoc($result)){
			foreach($row as $key => $val){
			$ypoint[$row["hospital_id"]] = $row["hospital_latitude"]; //병원의 x좌표
			$xpoint[$row["hospital_id"]] = $row["hospital_longitude"]; // 병원의 y좌표
			$name[$row["hospital_id"]] = $row["hospital_name"]; //병원의 이름
			}
		}

		if($value==NULL){
			$sql = "select * from patientinfo order by patient_id asc;";
			$result = mysqli_query($link,$sql);
			while($row = mysqli_fetch_assoc($result)){
				//마지막 hid일때 $last_key
				end($row); $last_key = key($row);
				print "<tr>";
				foreach($row as $key => $val){
					//hid column에서 x,y,name을 get으로 전달.
					if($key == $last_key){
						print '<td style = "cursor:pointer;" onClick = " location.href=\'mapsample.php?xpoint='.$xpoint[(int)$val].'&ypoint='.$ypoint[(int)$val].'&name='.$name[(int)$val].'\'
						" onMouseOver = " window.status = \'mapsample.php?xpoint='.$xpoint[(int)$val].'&ypoint='.$ypoint[(int)$val].'&name='.$name[(int)$val].'\'
						" onMouseOut = " window.status = \'\' ">'. $val .'</td>';
					}
					else
						print "<td>" . $val . "</td>";
				}
				print "</tr>";
			}
		}else{
			$sql = "select * from patientinfo where hospital_id = \"$value\" order by patient_id asc;";
			$result = mysqli_query($link,$sql);
			while($row = mysqli_fetch_assoc($result)){
				end($row); $last_key = key($row);
				print "<tr>";
				foreach($row as $key => $val){
					if($key == $last_key){
						print '<td style = "cursor:pointer;" onClick = " location.href=\'mapsample.php?xpoint='.$xpoint[(int)$value].'&ypoint='.$ypoint[(int)$value].'&name='.$name[(int)$value].'\'
						" onMouseOver = " window.status = \'mapsample.php?xpoint='.$xpoint[(int)$value].'&ypoint='.$ypoint[(int)$value].'&name='.$name[(int)$value].'\'
						" onMouseOut = " window.status = \'\' ">'. $val .'</td>';
					}
					else
						print "<td>" . $val . "</td>";
				}
				print "</tr>";
			}
		}
	?>
	</table>
	</body>
</table>

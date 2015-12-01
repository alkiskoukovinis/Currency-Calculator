<!-- Page View -->
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">

	<head>
		<title>Currency Calculator</title>
		<meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1">
		
		<link rel="stylesheet" type="text/css" href="../view/css/custom.css">
		<link rel="stylesheet" type="text/css" href="../view/css/bootstrap.css">
		
		<script type="text/javascript" src="../view/javascript/jquery-1.11.3.js"></script>
	</head>
	
	<body>
	<div id="calculator" >
		<h2>Currency Calculator</h2>
		<br/><br/>	
		
		<div class="form-group">
		
			<!-- Form of calculator-->
			<form id="calulatorForm" action="currency_calculator_controller.php" method="post">
				
				<input type="text" id="input_value" name="input_value" placeholder="input value">
				&nbsp;
				<select id="base_currency" name="base_currency">
					<?php foreach ($curencies_dynamic_array as $key=>$currency) { ?>
						<option value="<?php echo $key; ?>">
						<?php echo $currency; ?>
						</option>						
					<?php } ?><!-- end foreach -->
				</select>				
				<br/>
				&nbsp;
				&nbsp;
				&nbsp;
				&nbsp;
				&nbsp;
				&nbsp;
				&nbsp;				
				<button id="inversionBt" type="button">&#8645;</button> 
				&nbsp;
				<select id="target_currency" name="target_currency">
					<?php foreach ($curencies_dynamic_array as $key=>$currency) { ?>
						<option value="<?php echo $key; ?>">
						<?php echo $currency; ?>
						</option>						
					<?php } ?><!-- end foreach -->
				</select>
				&nbsp;
				<input type="hidden" id="output_value" name="output_value" value="<?php echo $output_value ?>" readonly>				
				&nbsp;
				<input type="submit" id="submit" name="submit" value="Calculate">
			</form>	
			
		</div>
		
		<br/>
		<br/>
		<!-- Error Messages -->
		<div id="errorMessage">
			<ul>
			<?php if (!empty($error_messages)){
				foreach ($error_messages as $message) {
					echo "<li>{$message}</li>";
				}				
			} ?>
			</ul>
		</div>
		<!-- Result Format -->
		<div id="result">
			<p><?php echo $result; ?></p>
		</div>	
	
	</div>
	
	<!-- javascript(jquery) in order to view the selected values -->
	<script type="text/javascript">
		$("#input_value").val("<?php echo $_POST["input_value"]; ?>");
		$("#base_currency").val("<?php echo $_POST["base_currency"]; ?>");
		$("#target_currency").val("<?php echo $_POST["target_currency"]; ?>");
	</script>
	<!-- custom javascript(jquery) script for further styling -->
	<script type="text/javascript" src="../view/javascript/script.js"></script>
	
	</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
    <title>Thêm mới số điện thoại</title>
    <script type="text/javascript" src="<?php echo base_url();?>vendor/bootstrap.js"></script>
 	<script type="text/javascript" src="<?php echo base_url();?>1.js"></script>
	<link rel="stylesheet" href="<?php echo base_url();?>vendor/bootstrap.css">
	<link rel="stylesheet" href="<?php echo base_url();?>vendor/font-awesome.css">
 	<link rel="stylesheet" href="<?php echo base_url();?>1.css">
</head>
<body>
	
	<div class="container">
		<h2 class="text-xs-center">Thêm số điện thoại ở trong form sau</h2>
		<hr>
	</div>
	<div class="container">
		<div class="row">
			<div class="col-sm-8 push-sm-2">
            <form action="<?php echo base_url();?>index.php/AddData/insertData_controller" method = "post">
               <fieldset class="form-group">
                    <label for="formGroupExampleInput" placeholder ="">Số</label>
                    <input id="formGroupExampleInput" class="form-control" type="text" placeholder ="Số sim: 0385699865" name="so">
               </fieldset>
               <fieldset class="form-group">
                    <label for="formGroupExampleInput" placeholder ="">Giá Tiền</label>
                    <input id="formGroupExampleInput" class="form-control" type="text" placeholder ="Giá: 256666" name="gia">
               </fieldset>
               <button type="submit" class="btn btn-succes btn-block">Gửi</button>
            </form>
			</div>
		</div>
	</div>
</body>
</html>
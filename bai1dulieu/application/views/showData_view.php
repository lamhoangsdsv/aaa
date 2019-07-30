<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Xem dữ liệu</title>
    <script type="text/javascript" src="<?php echo base_url();?>vendor/bootstrap.js"></script>
 	<script type="text/javascript" src="<?php echo base_url();?>1.js"></script>
	<link rel="stylesheet" href="<?php echo base_url();?>vendor/bootstrap.css">
	<link rel="stylesheet" href="<?php echo base_url();?>vendor/font-awesome.css">
 	<link rel="stylesheet" href="<?php echo base_url();?>1.css">
</head>
<body>
    <div class="container">
      
            <h3 class="text-xs-center"> Các sim và giá hiện có </h3>
            <hr>
        
    </div>
    <div class="container">
    <div class="row">

    <?php foreach ($duleutucontroller as $key => $value): ?> 
    

        <div class="col-sm-4">
            <div class="card card-block">
                <h3 class="card-title">Số sim: <?= $value['so'] ?></h3>
                <p class="card-text">Giá tiền: <?= $value['gia'] ?></p>
                <a href="showData/deletedata/<?= $value['id'] ?>" class="btn btn-danger xoa"><i class="fa fa-times"></i></a>
            </div>
        </div>

    <?php endforeach ?>

    </div>
    </div>
</body>
</html>
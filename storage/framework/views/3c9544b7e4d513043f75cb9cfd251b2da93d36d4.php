<!DOCTYPE html>
<html lang="en">
<head>
<title>Natioan Database</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

</head>
<body>

<table border="1" align="center">
    <tr>
        <td>Sl</td>
        <td>Branch Name</td>
        <td>Lat</td>
        <td>Long</td>
        <td>Photo</td>
    </tr>
    <?php $i = 1; foreach($infos as $info) { ?>
    <tr>
        <td><?php echo $i++; ?></td>
        <td><?php echo $info->branch_name;?></td>
        <td><?php echo $info->branch_lat;?></td>
        <td><?php echo $info->branch_long;?></td>
        <td><img src="<?php echo $info->branch_photo;?>" width="100" height="100"></td>
    </tr>
    <?php } ?>
</table>

</body>
</html>


<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <link rel="stylesheet" type="text/css" href="includes/public/css/flexigrid.css">
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
  <script type="text/javascript" src="includes/public/js/flexigrid.js"></script>
</head>
<body>
  <table id="flex1" style="display:none"></table>
  <script type="text/javascript">
    $("#flex1").flexigrid({
      url: 'index.php?rt=usuario/view_json',
      dataType: 'json',
      colModel : [
        {display: 'usuarios', name : 'email', width : 40, sortable : true, align: 'center'},
        ],
      searchitems : [
        {display: 'ISO', name : 'iso'},
        {display: 'Name', name : 'name', isdefault: true}
        ],
      sortname: "iso",
      sortorder: "asc",
      usepager: true,
      title: 'Countries',
      useRp: true,
      rp: 15,
      showTableToggleBtn: true,
      width: 700,
      height: 200
    });
  </script>
</body>
</html>



<h1><?php echo $blog_heading; ?></h1>

<p><?php echo $blog_content; ?></p>

<table>
<?php foreach ($filas as $key => $value) { ?>
	<tr>
	<?php foreach ($value as $name_col => $valor) { ?>
			<td><?php echo $valor ?></td>
	<?php	} ?>
	</tr>
<?php } ?>
</table>



<?php
include_once("head.php"); 
include_once("headermenu.php");
include_once("dbconfig.php");

if(!isset($_GET['items_per_page']))
$_GET['items_per_page'] = 25;
$usedvoucher = array('0'=>'No','1'=>'Yes');
?>
<div class="container">
  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script>
   $(function() {
    $( "#assigned_date" ).datepicker({
      showOn: "button",
      buttonImage: "images/calendar.gif",
      buttonImageOnly: true,
      buttonText: "Select assign date",
      dateFormat: "yy-m-d"

    });
	 

  });
  </script>
   
  
<h1> Manage Service Prefix information </h1>

<script>
function checkdelte(id){
//alert(id);
 
if (confirm('Are you sure you want to Remove ?')) {
    window.location.href = "addserviceprefix.php?action=delete&id="+id;
    // Save it!
} 

}
</script>

<form role="form" method="GET" action="<?php echo $_SERVER['PHP_SELF']; ?>">
<div class="row">
<?php
 if(isset($_SESSION['SuccessMsg'])){
?>
<div class="alert alert-success">
  <strong><?php echo $_SESSION['SuccessMsg']; ?> !</strong> 
</div>
<?php 
unset($_SESSION['SuccessMsg']);
}
?>
</div>
 

 



 

<div class="row"> &nbsp;</div>

<div class="row">
<div class="table-responsive">
   
<?php  
 $_PHP_SELF = $_SERVER['PHP_SELF'];
 
//echo "<pre>"; print_r($_GET); 


$sqlRedeemed= "SELECT * FROM  serviceprefixmaster ";  
$rs_resultRedeemed = mysqli_query($_SERVER['con'],$sqlRedeemed);  


$compniesList = array();
$sql = "SELECT id,nameofcompany FROM company";
$result = mysqli_query($_SERVER['con'],$sql);
while($row = mysqli_fetch_object($result)){
$compniesList[$row->id] = $row->nameofcompany;
}


$condition = array();
$condition = " WHERE  1=1 ";
$linkurl = "";

if (isset($_GET['Go'])){
 

	$linkurl  = $linkurl."&Go=submit"; 



	 

	if (strlen(trim($_GET['book_value']))>0 && isset($_GET['book_value'])){
	$book_value = $_GET['book_value'];
	$condition = $condition." AND book_value = $book_value";
	$linkurl  = $linkurl."&book_value=$book_value"; 
	}	

 

	if (strlen(trim($_GET['assigned_date']))>0 && isset($_GET['assigned_date'])){
	$assigned_date = $_GET['assigned_date'];
	$condition = $condition." AND DATE(assigned_date)='$assigned_date' ";
	$linkurl  = $linkurl."&assigned_date=". urlencode($assigned_date);
	}

	if (strlen($_GET['items_per_page'])>0 && isset($_GET['items_per_page'])){
	 $items_per_page = $_GET['items_per_page'];
	 $linkurl  = $linkurl."&items_per_page=".$items_per_page;
	}


	if (strlen($_GET['voucher_status'])>0 && isset($_GET['voucher_status']) ){
		$voucher_status = $_GET['voucher_status'];
		$condition = $condition." AND voucher_status = $voucher_status";
		$linkurl  = $linkurl."&voucher_status=".$voucher_status; 
	}


	if (strlen(trim($_GET['voucher_id']))>0 && isset($_GET['voucher_id'])){
	$voucher_id = $_GET['voucher_id'];
	$condition = $condition." AND voucher_id = $voucher_id ";
	$linkurl  = $linkurl."&&voucher_id=$voucher_id";
	
 	}
 

//echo $linkurl;

}

 
$sql = "SELECT * FROM serviceprefixmaster";  
$rs_result = mysqli_query($_SERVER['con'],$sql);  
?>  
<a href="addserviceprefix.php"> Add New Prefix </a>
<table class="table table-bordered table-striped" border="1">  
<thead>  
<tr>   
<th>S.No</th>
<th>Prefix</th>
<th>Description</th>
<th> &nbsp;</th>
<th> &nbsp;</th>
</tr>   
<thead>  
<tbody>  
<?php  
$k=1;
while ($row = mysqli_fetch_object($rs_result)) {  
?>  
<tr>
<td><?php echo $k;?></td>
<td><?php echo $row->prefix;?></td>
<td><?php echo $row->description;?></td>
<td> <a href="<?php echo 'editserviceprefix.php?action=edit&id='.$row->id;?>"> Edit </a> </td>

<td style="text-align:center">  &nbsp; &nbsp; <image src="remove.png" width="20" height="20" title="Delete" onclick="checkdelte(<?php echo $row->id;?>)"/> </td>
</tr>
 
<?php
$k = $k + 1;
}
?>  
</tbody>  
</table> 

<div class="row">


 


 
 

 

<div class="col-md-2">
<input type="submit" name="Go" value="submit" />
</div>


</div>
</div>
</div> 
</form>
<?php
mysqli_close($_SERVER['con']);
?>                    
<body>

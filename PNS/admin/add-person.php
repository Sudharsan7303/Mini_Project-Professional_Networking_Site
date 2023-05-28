<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if (strlen($_SESSION['pnsid']==0)) {
  header('location:logout.php');
  } else{
    if(isset($_POST['submit']))
  {

$pnsid=$_SESSION['pnsid'];
$name=$_POST['name'];
$mobnum=$_POST['mobilenumber'];
$address=$_POST['address'];
$city=$_POST['city'];
$category=$_POST['category'];
$propic=$_FILES["propic"]["name"];
$workimage=$_FILES["workimage"]["name"];
$exp=$_POST['exp'];

$extension = substr($propic,strlen($propic)-4,strlen($propic));
$extension1=substr($workimage,strlen($workimage)-4,strlen($workimage));
$certification=$_FILES["certification"]["name"];
$extension2=substr($certification,strlen($certification)-4,strlen($certification));
$allowed_extensions = array(".jpg","jpeg",".png",".gif");
if(!in_array($extension,$allowed_extensions) && !in_array($extension1,$allowed_extensions) && !in_array($extension2,$allowed_extensions))
{
echo "<script>alert(' Pics has Invalid format. Only jpg / jpeg/ png /gif format allowed');</script>";
}
else
{

$propic=md5($propic).time().$extension;
 move_uploaded_file($_FILES["propic"]["tmp_name"],"images/".$propic);
$workimage=md5($workimage).time().$extension1;
 move_uploaded_file($_FILES["workimage"]["tmp_name"],"images/".$workimage);
$certification=md5($certification).time().$extension2;
 move_uploaded_file($_FILES["certification"]["tmp_name"],"images/".$certification);
$sql="insert into tblperson(Category,Name,Picture,MobileNumber,Address,City,exp,workimage,certification)values(:cat,:name,:pics,:mobilenumber,:address,:city,:exp,:workimage,:certification)";
$query=$dbh->prepare($sql);
$query->bindParam(':name',$name,PDO::PARAM_STR);
$query->bindParam(':pics',$propic,PDO::PARAM_STR);
$query->bindParam(':cat',$category,PDO::PARAM_STR);
$query->bindParam(':mobilenumber',$mobnum,PDO::PARAM_STR);
$query->bindParam(':address',$address,PDO::PARAM_STR);
$query->bindParam(':city',$city,PDO::PARAM_STR);
$query->bindParam(':exp',$exp,PDO::PARAM_STR);
$query->bindParam(':workimage',$workimage,PDO::PARAM_STR);
$query->bindParam(':certification',$certification,PDO::PARAM_STR);
 $query->execute();

   $LastInsertId=$dbh->lastInsertId();
   if ($LastInsertId>0) {
    echo '<script>alert("Person Detail has been added.")</script>';
echo "<script>window.location.href ='add-person.php'</script>";
  }
  else
    {
         echo '<script>alert("Something Went Wrong. Please try again")</script>';
    }

  
}
}
?>
<!DOCTYPE html>
<html>
<head>
  
  <title>PNS | Add Person</title>
    
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <?php include_once('includes/header.php');?>

 
<?php include_once('includes/sidebar.php');?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Add Person</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
              <li class="breadcrumb-item active">Add Person</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Add Person</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" method="post" enctype="multipart/form-data">
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Service Category</label>
                    <select type="text" name="category" id="category" value="" class="form-control" required="true">
<option value="">Choose Category</option>
                                                        <?php 

$sql2 = "SELECT * from   tblcategory ";
$query2 = $dbh -> prepare($sql2);
$query2->execute();
$result2=$query2->fetchAll(PDO::FETCH_OBJ);

foreach($result2 as $row)
{          
    ?>  
<option value="<?php echo htmlentities($row->Category);?>"><?php echo htmlentities($row->Category);?></option>
 <?php } ?> 
            
                                                        
                                                    </select>
                  </div>
                     <div class="form-group">
                    <label for="exampleInputEmail1">Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Name" required="true">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Profile Pics</label>
                    <input type="file" class="form-control" id="propic" name="propic" required="true">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Mobile Number</label>
                    <input type="text" class="form-control" id="mobilenumber" name="mobilenumber" placeholder="Mobile Number" maxlength="10" pattern="[0-9]+" required="true">
                  </div> 
                  <div class="form-group">
                    <label for="exampleInputEmail1">Address</label>
                    <textarea type="text" class="form-control" id="address" name="address" placeholder="Address" required="true"></textarea>
                  </div> 
                  <div class="form-group">
                    <label for="exampleInputEmail1">City</label>
                    <input type="text" class="form-control" id="city" name="city" placeholder="City" required="true">
                  </div>  
                  <div class="form-group">
                    <label for="exampleInputEmail1">Experience</label>
                    <input type="text" class="form-control" id="exp" name="exp" placeholder="Experience" required="true">
                  </div> 
                  <div class="form-group">
                    <label for="exampleInputEmail1">Sample image of your work</label><br>
                    <input type="file" class="form-control" id="workimage" name="workimage" required="true">
                  </div><br>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Licenses or Certification</label><br>
                    <input type="file" class="form-control" id="certification" name="certification" required="true">
                  </div><br>
                </div>
              
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary" name="submit">Add</button>
                </div>
              </form>
            </div>
            <!-- /.card -->

          </div>
          <!--/.col (left) -->
          <!-- right column -->
         
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
 
<?php include_once('includes/footer.php');?>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- bs-custom-file-input -->
<script src="plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<script type="text/javascript">
$(document).ready(function () {
  bsCustomFileInput.init();
});
</script>
</body>
</html>
<?php }  ?>
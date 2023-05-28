<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');
if(isset($_POST['submit']))
  {
	
$name=$_POST['name'];
$mobnum=$_POST['mobilenumber'];
$address=$_POST['address'];
$city=$_POST['city'];
$category=$_POST['category'];
$exp=$_POST['exp'];
$propic=$_FILES["propic"]["name"];
$extension = substr($propic,strlen($propic)-4,strlen($propic));
$workimage=$_FILES["workimage"]["name"];
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
$sql="insert into tblnewserviceman(Category,Name,Picture,MobileNumber,Address,City,Experience,WorkImages,certification)values(:cat,:name,:pics,:mobilenumber,:address,:city,:exp,:workimage,:certification)";
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
    echo '<script>alert("Your details has been sent.Further information will be Added. ")</script>';

  }
  else
    {
         echo '<script>alert("Something Went Wrong. Please try again")</script>';
    }

  
}}
?>
<!DOCTYPE html>
<html>
<head>
    
	
	<title>PNS|Be a Service Provider</title>
	<style>
		form{
			margin:130px;
		}
		.subhead{
			font-size: 20px;
		}
	</style>
	
    
    <!--================================BOOTSTRAP STYLE SHEETS================================-->
        
	<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
	
    <!--================================ Main STYLE SHEETs====================================-->
	
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/menu.css">
	<link rel="stylesheet" type="text/css" href="css/color/color.css">
	<link rel="stylesheet" type="text/css" href="assets/testimonial/css/style.css" />
	<link rel="stylesheet" type="text/css" href="assets/testimonial/css/elastislide.css" />
	<link rel="stylesheet" type="text/css" href="css/responsive.css">

	<!--================================FONTAWESOME==========================================-->
		
    <link rel="stylesheet" type="text/css" href="css/font-awesome.css">
        
	<!--================================GOOGLE FONTS=========================================-->
	<link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Montserrat:400,700|Lato:300,400,700,900'>  
		
	<!--================================SLIDER REVOLUTION =========================================-->
	
	<link rel="stylesheet" type="text/css" href="assets/revolution_slider/css/revslider.css" media="screen" />
	<style>
		form{
			margin:110px;
		}
		.subhead{
			font-size: 20px;
		}
	</style>
		
</head>
<body>
	<div class="preloader"><span class="preloader-gif"></span></div>
	<div class="theme-wrap clearfix">
		<!--================================responsive log and menu==========================================-->
		<div class="wsmenucontent overlapblackbg"></div>
		<div class="wsmenuexpandermain slideRight">
			<a id="navToggle" class="animated-arrow slideLeft"><span></span></a>
			<a href="#" class="smallogo"><img src="images/logo.png" width="120" alt="" /></a>
		</div>
		<?php include_once('includes/header.php');?>
		
		<!--================================PAGE TITLE==========================================-->
		<div class="page-title-wrap bgorange-1 padding-top-30 padding-bottom-30"><!-- section title -->
			<h4 class="white">Are you a service provider?</h4>
		</div><!-- section title end -->
		
		<!--================================Register as service provider===========================================-->
		
		<h2 class="head">REGISTER YOURSELF AS A SERVICE PROVIDER:</h2><br>
	   <p class="subhead">Fill up the following details this will reach our admin and once you are verified you will be informed</p>


	<form role="form" method="post" enctype="multipart/form-data" action="mail.php">
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
            <label for="exampleInputEmail1">Name</label><br>
            <input type="text" class="form-control" id="name" name="name" placeholder="Name" required="true">
          </div><br>
          <div class="form-group">
            <label for="exampleInputEmail1">Profile Picture</label><br>
            <input type="file" class="form-control" id="propic" name="propic" required="true">
          </div><br>
          <div class="form-group">
            <label for="exampleInputEmail1">Mobile Number</label><br>
            <input type="text" class="form-control" id="mobilenumber" name="mobilenumber" placeholder="Mobile Number" maxlength="10" pattern="[0-9]+" required="true">
          </div> <br>
		  <div class="form-group">
            <label for="exampleInputEmail1">Email</label><br>
            <input type="email" class="form-control" id="email" name="email" placeholder="Email"  required="true">
          </div> <br>
          <div class="form-group">
            <label for="exampleInputEmail1">Address</label><br>
            <textarea type="text" class="form-control" id="address" name="address" placeholder="Address" required="true"></textarea>
          </div> <br>
          <div class="form-group">
            <label for="exampleInputEmail1">City</label><br>
            <input type="text" class="form-control" id="city" name="city" placeholder="City" required="true">
          </div>  <br>
          <div class="form-group">
            <label for="exampleInputEmail1">Working Experience</label><br>
            <input type="text" class="form-control" id="exp" name="exp" placeholder="Working Experience" required="true">
          </div> <br> 
		  <div class="form-group">
            <label for="exampleInputEmail1">Sample image of your work</label><br>
            <input type="file" class="form-control" id="workiImages" name="workimage" required="true">
          </div><br>
		  <div class="form-group">
            <label for="exampleInputEmail1">Licenses or Certification</label><br>
            <input type="file" class="form-control" id="certification" name="certification" required="true">
          </div><br>
        </div>
      
        <div class="card-footer">
          <button type="submit" class="btn btn-primary" name="submit">SEND DETAILS</button>
        </div>
      </form>
		<?php include_once('includes/footer.php');?>
	</div>

        
	<script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
	<script src="js/jquery.js"></script><!-- jquery 1.11.2 -->
	<script src="js/jquery.easing.min.js"></script>
	<script src="js/modernizr.custom.js"></script>
	
	<!--================================BOOTSTRAP===========================================-->
        
	<script src="bootstrap/js/bootstrap.min.js"></script>	
	
	<!--================================NAVIGATION===========================================-->
	
	<script type="text/javascript" src="js/menu.js"></script>
	
	<!--================================SLIDER REVOLUTION===========================================-->
		
	<script type="text/javascript" src="assets/revolution_slider/js/revolution-slider-tool.js"></script>
	<script type="text/javascript" src="assets/revolution_slider/js/revolution-slider.js"></script>
	
	<!--================================MAP===========================================-->
		
	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBueyERw9S41n4lblw5fVPAc9UqpAiMgvM"></script>
	<script type="text/javascript" src="js/map.js"></script>
	
	<!--================================OWL CARESOUL=============================================-->
		
	<script src="js/owl.carousel.js"></script>
    <script src="js/triger.js" type="text/javascript"></script>
		
	<!--================================FunFacts Counter===========================================-->
		
	<script src="js/jquery.countTo.js"></script>
	
	<!--================================jquery cycle2=============================================-->
	
	<script src="js/jquery.cycle2.min.js" type="text/javascript"></script>	
	
	<!--================================waypoint===========================================-->
		
	<script type="text/javascript" src="js/jquery.waypoints.min.js"></script><!-- Countdown JS FILE -->
	
	<!--================================RATINGS===========================================-->	
	
	<script src="js/jquery.raty-fa.js"></script>
	<script src="js/rate.js"></script>
	
	<!--================================ testimonial ===========================================-->
	<script id="img-wrapper-tmpl" type="text/x-jquery-tmpl">	
			
			<div class="rg-image-wrapper">
				<div class="rg-image"></div>
				<div class="rg-caption-wrapper">
					<div class="rg-caption" style="display:none;">
						<p></p>
						<h5></h5>
						<div class="caption-metas">
							<p class="position"></p>
							<p class="orgnization"></p>
						</div>
					</div>
				</div>
				<div class="clear"></div>
			</div>
		</script>	
	<script type="text/javascript" src="assets/testimonial/js/jquery.tmpl.min.js"></script>
	<script type="text/javascript" src="assets/testimonial/js/jquery.elastislide.js"></script>
	<script type="text/javascript" src="assets/testimonial/js/gallery.js"></script>
	
	<!--================================custom script===========================================-->
		
	<script type="text/javascript" src="js/custom.js"></script>
    
</body>
</html>
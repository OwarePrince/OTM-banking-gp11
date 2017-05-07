<?php
session_start();
error_reporting(0);
include("dbconnection.php");

if(($_REQUEST['error'])=='nologin')
    $logininfo="Please Sign In to Continue";
else if(($_REQUEST['error'])=='forgetpass')
    $logininfo="Please contact the nearest branch";
if(isset($_SESSION['customerid']))
{
	header("Location: accountalerts.php"); exit(0);
}
if(isset($_SESSION['adminid']))
{
    header("Location: admindashboard.php");
}
if ((isset($_REQUEST['login'])))
{
$password = mysql_real_escape_string($_REQUEST['password']);
$logid= mysql_real_escape_string($_REQUEST['login']);
$query="SELECT * FROM customers WHERE loginid='$logid' AND accpassword='$password'";
$res=  mysql_query($query);
if(mysql_num_rows($res) == 1)
	{
		while($recarr = mysql_fetch_array($res))
		{
			
		$_SESSION['customerid'] = $recarr['customerid'];
		$_SESSION['ifsccode'] = $recarr['ifsccode'];
		$_SESSION['customername'] = $recarr['firstname']. " ". $recarr['lastname'];
		$_SESSION['loginid'] = $recarr['loginid'];
		$_SESSION['accstatus'] = $recarr['accstatus'];
		$_SESSION['accopendate'] = $recarr['accopendate'];
		$_SESSION['lastlogin'] = $recarr['lastlogin'];		
		}
		$_SESSION["loginid"] =$_POST["login"];
		header("Location: accountalerts.php");
	}
else{
	$res = mysql_query("SELECT * FROM employees WHERE loginid='$logid' AND password='$password'");


	if(mysql_num_rows($res) == 1)
        
	{
           $collect = mysql_fetch_array($res);
        
		$_SESSION["adminid"] =$_POST["login"];
        if($collect['role']=='teller'){
            header("Location: teller.php");
        }
        else{
		header("Location: admindashboard.php");
            }
	}
	else
	{
		$logininfo = "Invalid Username or password entered";
	}
}
}
?>
<html>
<head>
<link href="images/Dashboard-512.png" rel="shortcut icon">
<?php include('header.php'); ?>
<link href="css/LoginPageStyle.css" rel="stylesheet" type="text/css" />
</head>
<body>
  <?php include('nav.php'); ?>
   
  <div style="padding-top:20px; padding-left:130px;" class="container" >
            <div class="row">
                <div class="col-sm-10 col-md-offset-2 ">
                  
                     <div id="directory" class="col-sm-6">
     <center><div class="panel panel-primary panel-center ">
  <div class="panel-heading">
        <center><h3 class="panel-title headings">Login</h3> </center>
   
      
  </div>
        <div class="panel-body ">
       
         
            
      <!--login form begins-->
        <form class="form-horizontal" style="margin-top:20px" role="form" action="login.php" autocomplete="on" method="post">
            <div class="form-group">
    <label class="control-label col-sm-3" for="email">Username:</label>
      <div class="col-sm-8">           
    <div class="input-group input-group-sm">
        <input  type="name" class="form-control" name="login" placeholder='Enter your username' required="required" autocomplete="on" ><span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
    </div>
  </div>
</div>                
       
  <div class="form-group">
    <label class="control-label col-sm-3" for="password">Password:</label>
       <div class="col-sm-8">
    <div class="input-group input-group-sm">
        <input type="password" class="form-control" name="password" required="required"><span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
    </div>
  </div>
        </div>
             <div class="form-group">
                
    <div class="col-sm-offset-3 ">
         <div class="col-sm-4">
      <button type="submit" name="go" id="go" class="btn btn-primary">Sign In</button>
    </div>
  </div>
 </div>
          </form>
             
            
</div> 
        <br>
        <br>
      <div class="panel-footer">
         <center> <a href="home.php"  class="btn btn-danger">Cancel</a> </center>
      </div>
    </div>  </center>
</div> 
  </div>
   </div>        
        
        
        </div>
<?php include'footer.php' ?>
</body>
</html>

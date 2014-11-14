<?php 
session_start();

include "config.php";
include_once "include/functions.php";

if(!isset($_SESSION[login])){
header("Location: " . $domena . "login/");
exit;
}


$sidebarmenu = 'slider';
$sidebarsubmenu = 'wszystkie-slidery';

if(ISSET($_GET[status]) AND ISSET($_GET[id])){

      $status = mysql_escape_string(strip_tags($_GET[status]));
      $id = mysql_escape_string($_GET[id]);

      if($status == 'publish')
      {
          $sql = "UPDATE sliders SET status='on' WHERE id='$id'";
            if(mysql_query($sql, CONNECT)){
                $message = "Slide #".$id." opublikowany";
            }else{
                $error = "Error<br />".mysql_error();
            }
      }
      elseif($status == 'pending')
      {
          $sql = "UPDATE sliders SET status='off' WHERE id='$id'";
            if(mysql_query($sql, CONNECT)){
                $message = "Slide #".$id." ustawiony jako oczekujący";
            }else{
                $error = "Error<br />".mysql_error();
          }
      }

}

if(ISSET($_GET[delete]) AND ISSET($_GET[id])){

      $delete = mysql_escape_string(strip_tags($_GET[delete]));
      $id = mysql_escape_string($_GET[id]);
      
      if($delete == 'yes')
      {
          $sql = "SELECT * FROM sliders WHERE id = $id";
          $res = mysql_query($sql,CONNECT);
          if(mysql_num_rows($res) > 0){
          $row = mysql_fetch_array($res);
          
          $year = date('Y', strtotime($row[date]));
          $month = date('m', strtotime($row[date]));
          
          if($row[date] != '' AND $row[image] != ''){
          $dir = '../pics/slider/'.$year.'/'.$month.'/'.$row[image];
          if (is_dir($dir)) {
          removeDir($dir);
          $message .= "Zdjęcia usunięte<br />"; 
          }
          $sql_del = "DELETE FROM sliders WHERE id='$id'";
            if(mysql_query($sql_del, CONNECT)){
                $message .= "Slide #".$id." skasowany";
            }else{
                $error .= "Error<br />".mysql_error();
            }
            
          }else {
           $error .= "Error<br />Nie ma newsa o numerze #".$id;
          }
          }else {
           $error .= "Error<br />Coś nie tak z kasowaniem #".$id;
           }
      }
}


if(ISSET($_GET['up'])){
    
$sql_up = "SELECT *, (SELECT t2.id FROM sliders as t2 WHERE t2.position = t1.position - 1 LIMIT 0, 1) as upper FROM sliders as t1 WHERE t1.id='$_GET[up]'";
$res_up = mysql_query($sql_up,CONNECT);
$row_up = mysql_fetch_array($res_up);

if($row_up['position'] != "1"){
$sql = "UPDATE sliders SET position = $row_up[position] WHERE id = $row_up[upper]";
mysql_query($sql, CONNECT);
$sql = "UPDATE sliders SET position = $row_up[position]-1 WHERE id = $row_up[id]";
mysql_query($sql, CONNECT);
$message = "Slide ".$row_up['name'].": Przesunięto do góry";
}else {
 $error = "You can not move the category up because it is the first place";
}


}

if(ISSET($_GET['down'])){
    
$sql_up = "SELECT *, (SELECT t2.id FROM sliders as t2 WHERE t2.position = t1.position + 1 LIMIT 0, 1) as lower, (SELECT MAX(position) FROM sliders as t4) as max FROM sliders as t1 WHERE t1.id='$_GET[down]'";
$res_up = mysql_query($sql_up,CONNECT);
$row_up = mysql_fetch_array($res_up);


if($row_up['position'] != $row_up['max']){
$sql = "UPDATE sliders SET position = $row_up[position] WHERE id = $row_up[lower]";
mysql_query($sql, CONNECT);
$sql = "UPDATE sliders SET position = $row_up[position]+1 WHERE id = $row_up[id]";
mysql_query($sql, CONNECT);
$message = "Slide ".$row_up['name'].": Przesunietow w dół";
}else {
 $error = "You can not move the category down because it is the last place";
}


}


$_SESSION[login] = mysql_escape_string(strip_tags($_SESSION[login]));
$sql = "SELECT * FROM users WHERE login='$_SESSION[login]'";
$res = mysql_query($sql,CONNECT);
$row = mysql_fetch_array($res);

$sql2 = "SELECT *, LEFT(content , 500) as content FROM sliders ORDER BY position ASC";
$res2 = mysql_query($sql2,CONNECT);
$count2 = mysql_num_rows($res2);



?>

<!DOCTYPE html>

<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
	<title>LISTA ZDJĘĆ SLIDERA ZE STRONY GŁÓWNEJ: <? print $title_tag; ?></title>
	<? include "constans/head.php"; ?>
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="fixed-top">
	<!-- BEGIN HEADER -->
	<div class="header navbar navbar-inverse navbar-fixed-top">
		<!-- BEGIN TOP NAVIGATION BAR -->
		<div class="navbar-inner">
			<div class="container-fluid">
				<!-- BEGIN LOGO -->
				<a class="brand" href="<? print $domena; ?>">
				<img src="assets/img/logo.png" alt="logo" />
				</a>
				<!-- END LOGO -->
				<!-- BEGIN RESPONSIVE MENU TOGGLER -->
				<a href="javascript:;" class="btn-navbar collapsed" data-toggle="collapse" data-target=".nav-collapse">
				<img src="assets/img/menu-toggler.png" alt="" />
				</a>          
				<!-- END RESPONSIVE MENU TOGGLER -->				
				<!-- BEGIN TOP NAVIGATION MENU -->					
				<ul class="nav pull-right">
					<!-- BEGIN NOTIFICATION DROPDOWN -->	
					<li class="dropdown" id="header_notification_bar">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<i class="icon-warning-sign"></i>
						<!--<span class="badge">0</span> -->
						</a>
						<ul class="dropdown-menu extended notification">
							<li>
								<p>Nie masz żadnych powiadomień</p>
							</li>
							<li class="external">
								<a href="#">zobacz wszystkie <i class="m-icon-swapright"></i></a>
							</li>
						</ul>
					</li>
					<!-- END NOTIFICATION DROPDOWN -->
					<!-- BEGIN INBOX DROPDOWN -->
					<li class="dropdown" id="header_inbox_bar">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<i class="icon-envelope-alt"></i>
						<!--<span class="badge">0</span> -->
						</a>
						<ul class="dropdown-menu extended inbox">
							<li>
								<p>Brak nowych wiadomości</p>
							</li>
							<li class="external">
								<a href="#">Zobacz wszystkie <i class="m-icon-swapright"></i></a>
							</li>
						</ul>
					</li>
					<!-- END INBOX DROPDOWN -->
					<!-- BEGIN TODO DROPDOWN -->
					<li class="dropdown" id="header_task_bar">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<i class="icon-tasks"></i>
						<!-- <span class="badge">5</span> -->
						</a>
						<ul class="dropdown-menu extended tasks">
							<li>
								<p>Brak nowych zadań</p>
							</li>
							<li class="external">
								<a href="#">Zobacz wszystkie <i class="m-icon-swapright"></i></a>
							</li>
						</ul>
					</li>
					<!-- END TODO DROPDOWN -->
					<!-- BEGIN USER LOGIN DROPDOWN -->
					<li class="dropdown user">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<img alt="" src="assets/img/avatar1_small.jpg" />
						<span class="username"><?php echo ' '.$row['imie'].' '.$row['nazwisko']; ?></span>
						<i class="icon-angle-down"></i>
						</a>
						<ul class="dropdown-menu">
							<li><a href="extra_profile.html"><i class="icon-user"></i> Mój profil</a></li>
							<li><a href="calendar.html"><i class="icon-calendar"></i> Zmiana hasła</a></li>
							<li><a href="#"><i class="icon-bar-chart"></i> Statystyki</a></li>
							<li class="divider"></li>
							<li><a href="<? print $domena; ?>logout/"><i class="icon-key"></i> Wyloguj</a></li>
						</ul>
					</li>
					<!-- END USER LOGIN DROPDOWN -->
				</ul>
				<!-- END TOP NAVIGATION MENU -->	
			</div>
		</div>
		<!-- END TOP NAVIGATION BAR -->
	</div>
	<!-- END HEADER -->
	<!-- BEGIN CONTAINER -->
	<div class="page-container row-fluid">
		<!-- BEGIN SIDEBAR -->
		<div class="page-sidebar nav-collapse collapse">
			<!-- BEGIN SIDEBAR MENU -->        	
      <?php include "constans/menu.php"; ?>
			<!-- END SIDEBAR MENU -->
		</div>
		<!-- END SIDEBAR -->
		<!-- BEGIN PAGE -->
		<div class="page-content">
			<!-- BEGIN PAGE CONTAINER-->
			<div class="container-fluid">
				<!-- BEGIN PAGE HEADER-->
				<div class="row-fluid">
					<div class="span12"> 	
						<!-- BEGIN PAGE TITLE & BREADCRUMB-->			
						<h3 class="page-title">
							ZDJĘCIA SLIDERA				
							<small>lista</small>
						</h3>
						<ul class="breadcrumb">
							<li>
								<i class="icon-home"></i>
								<a href="<? print $domena; ?>">Strona Główna</a> 
								<i class="icon-angle-right"></i>
							</li>
							<li>
								
								<a href="<? print $domena; ?>wszystkie-slidery/">Wszystkie slide'y</a> 
								
							</li>
							<li class="pull-right no-text-shadow">
								
							</li>
							
						</ul>
						<!-- END PAGE TITLE & BREADCRUMB-->
					</div>
				</div>
				<!-- END PAGE HEADER-->
					<div class="row-fluid">
					<div class="span12">
						<!-- BEGIN EXAMPLE TABLE PORTLET-->
						<div class="portlet box blue">
							<div class="portlet-title">
								<h4><i class="icon-reorder"></i>Wszystkie zdjęcia slidera ze strony głównej</h4>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>

								</div>
							</div>
							<div class="portlet-body">
              <? if(ISSET($error)) { ?>
      <div class="alert alert-error">
      <button class="close" data-dismiss="alert"></button>
      <strong>Błąd!</strong><br />
      <? echo $error; ?>					
      </div>
      <? } 
      if(ISSET($message)) { ?>
      <div class="alert alert-success">
      <button class="close" data-dismiss="alert"></button>
      <strong>Sukces!</strong><br />
      <? echo $message; ?>					
      </div>
      <? } ?>
								<table class="table table-striped table-bordered" id="sample_1">
									<thead>
										<tr>
											<th style="width:8px;"><input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes" /></th>
                      <th>Tytuł</th>
											<th>Publikacja</th>
                      <th>Pozycja</th>
                      <th>Status</th>
										</tr>
									</thead>
									<tbody>
									  <? for($i=0; $i<$count2; $i++){
                    $row2 = mysql_fetch_array($res2); 
                    $nice_url = clean($row2['title'], " ");
                    $year = date('Y', strtotime($row2[date]));
                    $month = date('m', strtotime($row2[date]));
                    ?> 
                    <tr class="odd gradeX">
											<td><input type="checkbox" class="checkboxes" value="1" /></td>
											<td><img src="<? print $main_domain."pics/slider/".$year."/".$month."/".$row2['image']."/".$nice_url."_84x49px.jpg"; ?>" alt="pic" class="float-left margin-right-4"/> <a href="<? print $domena; ?>edytuj-slider/?id=<? print $row2[id]; ?>"><strong><? print $row2[title]; ?></strong></a><br />
                      <small class="muted">news napisany przez <a href="#"><? print $row2[author]; ?></a></small> 
                      </td>
                      <td>
                      <? print $row2[date]; ?><br />
                      
                      </td>
                      <td>
                      <? if($i == '0'){ ?>
                      <a class="btn grey icn-only float-left">
                        <i class="m-icon-swapup m-icon-white"></i>
                      </a> 
                      <? } else { ?>
                      <a href="<? print $domena; ?>wszystkie-slidery/?up=<? print $row2[id]; ?>" class="btn blue icn-only float-left">
                        <i class="m-icon-swapup m-icon-white"></i>
                      </a> 
                      <? } ?>
                      <? if($i+1 == $count2){ ?>
                      <a class="btn grey icn-only red-stripe float-left">
                        <i class="m-icon-swapdown m-icon-white"></i>
                      </a>
                      <? } else { ?>
                      <a href="<? print $domena; ?>wszystkie-slidery/?down=<? print $row2[id]; ?>" class="btn blue icn-only red-stripe float-left">
                        <i class="m-icon-swapdown m-icon-white"></i>
                      </a>
                      <? } ?>
                      </td>
                      <td>
                     
                      <div class="btn-group">
                       <? 
                      if($row2[status] == 'on'){
                      ?>
                        <a class="btn green-stripe dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="icon-ok"></i>
                        opublikowany 
                        <i class="icon-angle-down"></i>
                        </a>
                        <ul class="dropdown-menu">
                          <li>
                            <a href="<? print $domena; ?>wszystkie-slidery/?status=pending&id=<? print $row2[id]; ?>">oczekuje</a>
                          </li>
                        </ul>
                      <?php
                      }else{
                      ?>
                      <a class="btn red-stripe dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="icon-warning-sign"></i>
                        oczekuje 
                        <i class="icon-angle-down"></i>
                        </a>
                        <ul class="dropdown-menu">
                          <li>
                            <a href="<? print $domena; ?>wszystkie-slidery/?status=publish&id=<? print $row2[id]; ?>">opublikuj</a>
                          </li>
                        </ul>
                      <?php
                      }
                   
                      ?>                       
                      <a href="<? print $domena; ?>wszystkie-slidery/?delete=yes&id=<? print $row2[id]; ?>" class="btn red icn-only">
                        <i class="icon-remove icon-white"></i>
                      </a>
                      
                      </div>
                      
                      </td>
										
										</tr>
                    <?
                    }
                    ?>
									
									</tbody>
								</table>
							</div>
						</div>
						<!-- END EXAMPLE TABLE PORTLET-->
					</div>
				</div>
					
			</div>
			<!-- END PAGE CONTAINER-->		
		</div>
		<!-- END PAGE -->
	</div>
	<!-- END CONTAINER -->
	<!-- BEGIN FOOTER -->
	<div class="footer">
		2013 &copy; varts.pl.
		<div class="span pull-right">
			<span class="go-top"><i class="icon-angle-up"></i></span>
		</div>
	</div>
<!-- END FOOTER -->
	<!-- BEGIN JAVASCRIPTS -->
	<!-- Load javascripts at bottom, this will reduce page load time -->
	<script src="<? print $domena; ?>assets/js/jquery-1.8.3.min.js"></script>	
	<script src="<? print $domena; ?>assets/breakpoints/breakpoints.js"></script>	
	<script src="<? print $domena; ?>assets/bootstrap/js/bootstrap.min.js"></script>		
	<script src="<? print $domena; ?>assets/js/jquery.blockui.js"></script>
	<script src="<? print $domena; ?>assets/js/jquery.cookie.js"></script>
	<!-- ie8 fixes -->
	<!--[if lt IE 9]>
	<script src="<? print $domena; ?>assets/js/excanvas.js"></script>
	<script src="<? print $domena; ?>assets/js/respond.js"></script>
	<![endif]-->	
	<script type="text/javascript" src="<? print $domena; ?>assets/uniform/jquery.uniform.min.js"></script>
	<script type="text/javascript" src="<? print $domena; ?>assets/data-tables/jquery.dataTables.js"></script>
	<script type="text/javascript" src="<? print $domena; ?>assets/data-tables/DT_bootstrap.js"></script>
	<script type="text/javascript" src="assets/bootstrap-daterangepicker/date.js"></script>
	<script type="text/javascript" src="assets/bootstrap-daterangepicker/daterangepicker.js"></script>
	<script src="<? print $domena; ?>assets/js/app2.js"></script>		
	<script>
		jQuery(document).ready(function() {			
			// initiate layout and plugins
			App.init();
		});
	</script>
	<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>

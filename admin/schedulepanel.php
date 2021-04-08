<?php
    session_start();

    if(!isset($_SESSION['id'])){
        header("Location: index.php");
    }
    
    $nombre = $_SESSION['nombre'];
    $usuario = $_SESSION['id'];

    $servidor="mysql:dbname=php;host=127.0.0.1";
    $usuario="root";
    $password="";

    try{
        $pdo = new PDO($servidor, $usuario, $password);
        
    }catch(PDOException $e){
        echo "Conexion mala ".$e->getMessage();
    }

   //Variables Schedule
    $id_class=(isset($_POST['id_class']))?$_POST['id_class']:"";
    $time_start=(isset($_POST['time_start']))?$_POST['time_start']:"";
    $time_end=(isset($_POST['time_end']))?$_POST['time_end']:"";
    $day=(isset($_POST['day']))?$_POST['day']:"";
    $course=(isset($_POST['course']))?$_POST['course']:"";
    $colour=(isset($_POST['colour']))?$_POST['colour']:"";
    $teacher=(isset($_POST['teacher']))?$_POST['teacher']:"";

    $action=(isset($_POST['action']))?$_POST['action']:"";
    

    switch($action){
        case "btnAdd":

            $sentencia=$pdo->prepare("INSERT INTO schedule (id_class,time_start,time_end,day,course,colour,teacher) 
            VALUES (:id_class,:time_start,:time_end,:day,:course,:colour,:teacher)");

            
            $sentencia->bindParam(':id_class', $id_class);
            $sentencia->bindParam(':time_start', $time_start);
            $sentencia->bindParam(':time_end', $time_end);
            $sentencia->bindParam(':day', $day);
            $sentencia->bindParam(':course', $course);
            $sentencia->bindParam(':colour', $colour);
            $sentencia->bindParam(':teacher', $teacher);
            $sentencia->execute();

            header("Location: schedulepanel.php");

                    
        break;
        case "btnModify":

            $sentencia=$pdo->prepare("UPDATE schedule SET 
            id_class=:id_class,
            time_start=:time_start,
            time_end=:time_end,
            day=:day,
            course=:course,
            colour=:colour,
            teacher=:teacher WHERE id_class=:id_class");
            
            
            $sentencia->bindParam(':id_class', $id_class);
            $sentencia->bindParam(':time_start', $time_start);
            $sentencia->bindParam(':time_end', $time_end);
            $sentencia->bindParam(':day', $day);
            $sentencia->bindParam(':course', $course);
            $sentencia->bindParam(':colour', $colour);
            $sentencia->bindParam(':teacher', $teacher);
            
            $sentencia->execute();
            header("Location: schedulepanel.php");

            
        break;
        case "btnDelete":
            
            $sentencia=$pdo->prepare("DELETE FROM schedule WHERE id_class=:id_class");
           
            
            $sentencia->bindParam(':id_class', $id_class);
         
            
            $sentencia->execute();

            header("Location: schedulepanel.php");

            
        
    }
    $sentencia= $pdo->prepare("SELECT * FROM `schedule`");
    $sentencia->execute();

    $listaSchedule=$sentencia->fetchAll(PDO::FETCH_ASSOC);
  
    

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Admin PHP-Legacy</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
     <link href="css/sb-admin-2.min.css" rel="stylesheet">

      <!-- Custom Form-->
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
     <!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>-->
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" >
                
                <div class="sidebar-brand-text mx-3">Admin PHP-Legacy</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <?php if($usuario == 0) { ?>
            <li class="nav-item active">
                <a class="nav-link" href="http://localhost/phpcalendar/admin/adminpanel.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Admin Panel</span></a>
            </li>
            <?php } ?>

            
            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
                    aria-expanded="true" aria-controls="collapsePages">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Actions</span>
                </a>
                <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                       
                        
                        <a class="collapse-item" href="http://localhost/phpcalendar/assets/calendar.php">Calendar</a>
                        <a class="collapse-item" href="http://localhost/phpcalendar/admin/userpage.php">User configuration</a>
                    </div>
                </div>
            </li>

            
           
            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>


        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                   <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                   
                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $nombre ?></span>
                                <img class="img-profile rounded-circle"
                                    src="img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                               
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
<!-- Tabla Schedule -->
                <h1>Schedule</h1>

                <form action="" method="post" extype="multipart/form-data" >
               

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Schedule</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-row">
          <label for="">id_class:</label>
                    <input type="text" class="form-control" name="id_class" value="<?php echo $id_class;?>" placeholder="" id="txt1" require="">
                    <br>

                    <label for="">time_start:</label>
                    <input type="datetime-local" class="form-control"  name="time_start" value="<?php echo $time_start;?>" placeholder="" id="txt2" require="">
                    <br>

                    <label for="">time_end:</label>
                    <input type="datetime-local" class="form-control"  name="time_end" value="<?php echo $time_end;?>" placeholder="" id="txt3" require="">
                    <br>

                    <label for="">day:</label>
                    <input type="date" class="form-control"  name="day" placeholder="" value="<?php echo $day;?>" id="txt4" require="">
                    <br>
                    <label for="">course:</label>
                    <input type="text" class="form-control"  name="course" placeholder="" value="<?php echo $course;?>" id="txt5" require="">
                    <br>
                    <label for="">colour:</label>
                    <input type="color" class="form-control"  name="colour" placeholder="" value="<?php echo $colour;?>" id="txt6" require="">
                    <br>
                    <label for="">teacher:</label>
                    <input type="number" class="form-control"  name="teacher" placeholder="" value="<?php echo $teacher;?>" id="txt7" require="">
                    <br>
            </div>
       
      </div>
      <div class="modal-footer">
                    <button value="btnAdd" class="btn btn-success" type="submit" name="action">Add</button>
                    <button value="btnModify" class="btn btn-success" type="submit" name="action">Modify</button>
                    <button value="btnDelete"  class="btn btn-primary" type="submit" name="action">Delete</button>
                    
      </div>
      
    </div>
  </div>
</div>
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
  Modify schedule
</button>
<p>Please push select to modify Schedule. 
</p>

                    
                  
                   

                </form>
            <div class="row">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Class</th>
                            <th>Start</th>
                            <th>End</th>
                            <th>Course</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                <?php foreach($listaSchedule as $schedule){ ?>
                    <tr>
                        <td><?php echo $schedule['id_class'];?></td>
                        <td><?php echo $schedule['time_start'];?></td>
                        <td><?php echo $schedule['time_end'];?></td>
                        <td><?php echo $schedule['course'];?></td>
                        <td>
                        <form action="" method="post">
                            <input type="hidden" name="id_schedule" value="<?php echo $schedule['id_schedule'];?>">
                            <input type="hidden" name="id_class" value="<?php echo $schedule['id_class'];?>">
                            <input type="hidden" name="time_start" value="<?php echo $schedule['time_start'];?>">
                            <input type="hidden" name="time_end" value="<?php echo $schedule['time_end'];?>">
                            <input type="hidden" name="day" value="<?php echo $schedule['day'];?>">
                            <input type="hidden" name="course" value="<?php echo $schedule['course'];?>">
                            <input type="hidden" name="colour" value="<?php echo $schedule['colour'];?>">
                            <input type="hidden" name="teacher" value="<?php echo $schedule['teacher'];?>">

                           
                            <input type="submit" class="btn btn-primary" value="Select" name="action">
                            <button value="btnDelete"  class="btn btn-primary" type="submit" name="action">Delete</button>
                        </form>
                        </td>
                    </tr>
                <?php }?>
                </table>
            </div>

        </div>


            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; PHP-LEGACY</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="logout.php">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>

</body>

</html>
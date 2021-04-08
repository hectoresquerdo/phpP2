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


    //Variables Teacher
    $id_teacher=(isset($_POST['id_teacher']))?$_POST['id_teacher']:"";
    $name=(isset($_POST['name']))?$_POST['name']:"";
    $surname=(isset($_POST['surname']))?$_POST['surname']:"";
    $telephone=(isset($_POST['telephone']))?$_POST['telephone']:"";
    $nif=(isset($_POST['nif']))?$_POST['nif']:"";
    $email=(isset($_POST['email']))?$_POST['email']:"";
    


    $action=(isset($_POST['action']))?$_POST['action']:"";
    

    switch($action){
        case "btnAdd":

            $sentencia=$pdo->prepare("INSERT INTO teachers (id_teacher,name,surname,telephone,nif,email) 
            VALUES (:id_teacher,:name,:surname,:telephone,:nif,:email)");

            
            $sentencia->bindParam(':id_teacher', $id_teacher);
            $sentencia->bindParam(':name', $name);
            $sentencia->bindParam(':surname', $surname);
            $sentencia->bindParam(':telephone', $telephone);
            $sentencia->bindParam(':nif', $nif);
            $sentencia->bindParam(':email', $email);
            
            $sentencia->execute();

            header("Location: teacherpanel.php");

                    
        break;
        case "btnModify":

            $sentencia=$pdo->prepare("UPDATE teachers SET 
            id_teacher=:id_teacher,
            name=:name,
            surname=:surname,
            telephone=:telephone,
            nif=:nif,
            email=:email
            WHERE id_teacher=:id_teacher");
            
            
            $sentencia->bindParam(':id_teacher', $id_teacher);
            $sentencia->bindParam(':name', $name);
            $sentencia->bindParam(':surname', $surname);
            $sentencia->bindParam(':telephone', $telephone);
            $sentencia->bindParam(':nif', $nif);
            $sentencia->bindParam(':email', $email);
            
            
            $sentencia->execute();
            header("Location: teacherpanel.php");

            
        break;
        case "btnDelete":
            
            $sentencia=$pdo->prepare("DELETE FROM teachers WHERE id_teacher=:id_teacher");
           
            
            $sentencia->bindParam(':id_teacher', $id_teacher);
         
            
            $sentencia->execute();

            header("Location: teacherpanel.php");

            
        break;
                
    }
    $sentencia= $pdo->prepare("SELECT * FROM `teachers`");
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
                        <a class="collapse-item" href="http://localhost/phpcalendar/admin/userpage.php">User settings</a>
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
                <h1>Teachers</h1>

                <form action="" method="post" extype="multipart/form-data" >
               

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Teachers</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-row">
                    <label for="">id_teacher:</label>
                    <input type="number" class="form-control" name="id_teacher" value="<?php echo $id_teacher;?>" placeholder="" id="txt1" require="">
                    <br>

                    <label for="">name:</label>
                    <input type="text" class="form-control"  name="name" value="<?php echo $name;?>" placeholder="" id="txt2" require="">
                    <br>

                    <label for="">surname:</label>
                    <input type="text" class="form-control"  name="surname" value="<?php echo $surname;?>" placeholder="" id="txt3" require="">
                    <br>

                    <label for="">telephone:</label>
                    <input type="text" class="form-control"  name="telephone" placeholder="" value="<?php echo $telephone;?>" id="txt4" require="">
                    <br>
                    <label for="">nif:</label>
                    <input type="text" class="form-control"  name="nif" placeholder="" value="<?php echo $nif;?>" id="txt5" require="">
                    <br>
                    <label for="">email:</label>
                    <input type="text" class="form-control"  name="email" placeholder="" value="<?php echo $email;?>" id="txt6" require="">
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
  Modify Teachers
</button>
<p>Please push select to modify Teacher. 
</p>


                </form>
            <div class="row">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Id_teacher</th>
                            <th>Name</th>
                            <th>Surname</th>
                            <th>Telephone</th>
                            <th>Nif</th>
                            <th>Email</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                <?php foreach($listaSchedule as $schedule){ ?>
                    <tr>
                        <td><?php echo $schedule['id_teacher'];?></td>
                        <td><?php echo $schedule['name'];?></td>
                        <td><?php echo $schedule['surname'];?></td>
                        <td><?php echo $schedule['telephone'];?></td>
                        <td><?php echo $schedule['nif'];?></td>
                        <td><?php echo $schedule['email'];?></td>
                        <td>
                        <form action="" method="post">
                            <input type="hidden" name="id_teacher" value="<?php echo $schedule['id_teacher'];?>">
                            <input type="hidden" name="name" value="<?php echo $schedule['name'];?>">
                            <input type="hidden" name="surname" value="<?php echo $schedule['surname'];?>">
                            <input type="hidden" name="telephone" value="<?php echo $schedule['telephone'];?>">
                            <input type="hidden" name="nif" value="<?php echo $schedule['nif'];?>">
                            <input type="hidden" name="email" value="<?php echo $schedule['email'];?>">
                           
                           
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
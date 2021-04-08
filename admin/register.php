<?php
    session_start();
    //Conect DB
    require "conexion.php";

    $id_user_admin=(isset($_POST['id_user_admin']))?$_POST['id_user_admin']:"";
    $username=(isset($_POST['username']))?$_POST['username']:"";
    $name=(isset($_POST['name']))?$_POST['name']:"";
    $email=(isset($_POST['email']))?$_POST['email']:"";
    $course=(isset($_POST['course']))?$_POST['course']:"";
    $password=(isset($_POST['password']))?$_POST['password']:"";
    $password2=(isset($_POST['password2']))?$_POST['password2']:"";
    $action=(isset($_POST['action']))?$_POST['action']:"";

    $pass_c=sha1($password);
    $pass_2=sha1($password2);



    $sentencia=$pdo->prepare("INSERT INTO users_admin (id_user_admin,username,name,email,password,course) 
            VALUES (:id_user_admin,:username,:name,:email,:password,:course)");

    

        if($action == "register"){
            $sentencia->bindParam(':id_user_admin', $id_user_admin);
            $sentencia->bindParam(':username', $username);
            $sentencia->bindParam(':name', $name);
            $sentencia->bindParam(':email', $email);
            $sentencia->bindParam(':password', $pass_c);
            $sentencia->bindParam(':course', $course);

                      
            if($pass_c == $pass_2){
                
                $sentencia->execute();  

                
                header("Location: index.php");
            }else{
                echo '<script>alert("The two passwords are different, try again!")</script>'; 
               
            }
        }

    
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Calendar PHP-LEGACY</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
     href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
       rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

    <div class="d-flex justify-content-center">

                <form action="" method="post" extype="multipart/form-data" > 
                <div class="card o-hidden border-0 shadow-lg my-5">
                        <div class="card-body p-0">
                            <!-- Nested Row within Card Body -->
                            <div class="row justify-content-center">
                                <!--<div class="col-lg-5 d-none d-lg-block bg-register-image"></div>-->
                                <div class="col-lg-6.5">
                                    <div class="p-5">
                                        <div class="text-center">
                                            <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                                        </div>
                                        <form method="post" action="register.php" class="user">
                                            <div class="form-group row">
                                                <div class="col-sm-6 mb-3 mb-sm-0">
                                                    <input type="text" class="form-control form-control-user"  name="username" 
                                                        placeholder="username" required>
                                                </div>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control form-control-user"  name="name" id="exampleLastName"
                                                        placeholder="name" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <input type="email" class="form-control form-control-user"  name="email" id="exampleInputEmail"
                                                    placeholder="Email Address" required>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-sm-6 mb-3 mb-sm-0">
                                                    <input type="password" class="form-control form-control-user"
                                                        id="exampleInputPassword" name="password"  placeholder="Password" required>
                                                </div>
                                                <div class="col-sm-6">
                                                    <input type="password" class="form-control form-control-user"
                                                        id="exampleRepeatPassword"  name="password2" placeholder="Repeat Password" required>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                    <input list="browsers" class="form-control form-control-user" name="course" id="exampleInputEmail" placeholder="Course" required>

                                                    <datalist id="browsers">
                                                    <option value="WEB">
                                                    <option value="DAM">
                                                    
                                                    </datalist>
                                                
                                            </div>
                                            <form action="" method="post">
                                                <input type="submit" value="register" name="action" class="btn btn-primary btn-user btn-block"/>
                                            </form>
                                            <hr>
                                
                                        </form>
                                        <hr>
                                        
                                        <div class="text-center">
                                            <a class="small" href="index.php">Already have an account? Login!</a>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>
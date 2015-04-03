<?php
    session_start();
    include 'server/sql.php';

    $message_section = $_SESSION['message_section'];
    $error_message = $_SESSION['error_message'];
    $success_message = $_SESSION['success_message'];

    $students_data = get_data_from_table('Student');
    $enrolled_data = get_data_from_table('Enrolled');
    $majors_data = get_data_from_table('MajorsIn');
    $department_data = get_data_from_table('Department');
    $course_data = get_data_from_table('Course');
    $room_data = get_data_from_table('Room');

    $student_name_lookup = array();
    foreach ($students_data as $row) {
        $student_name_lookup[$row['id']] = $row['name'];
    }

    $room_name_lookup = array();
    foreach ($room_data as $row) {
        $room_name_lookup[$row['id']] = $row['name'];
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Rehan Rasool - HW9</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/scrolling-nav.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<!-- The #page-top ID is part of the scrolling feature - the data-spy and data-target are part of the built-in Bootstrap scrollspy function -->

<body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">

    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header page-scroll">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand page-scroll" href="#page-top">University Portal</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav">
                    <!-- Hidden li included to remove active class from about link when scrolled up past about section -->
                    <li class="hidden">
                        <a class="page-scroll" href="#page-top"></a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#enrolled">Enrolled</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#majors">Majors</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#department">Departments</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#course">Courses</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#room">Rooms</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <!-- Students Section -->
    <section id="intro">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h3> Students </h3>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>
                                    ID
                                </th>
                                <th>
                                    Name
                                </th>
                                <th>
                                    Majors
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <? foreach ($students_data as $row){ ?>
                            <tr>

                                <td><?=$row['id']?></td>
                                <td><?=$row['name']?></td>
                                <td><?=$row['majors_count']?></td>
                            </tr>
                            <? } ?>
                        </tbody>
                    </table> 
                </div>
                <div class="col-md-12">
                    <? if ($message_section == 'intro' && $success_message != 'none') { ?>
                    <div class="alert alert-success">
                        <a href="#" class="close" data-dismiss="alert">&times;</a>
                        <strong>Success!</strong> <?=$success_message?>
                    </div>
                    <? } ?>
                    <? if ($message_section == 'intro' && $error_message != 'none') { ?>
                    <div class="alert alert-danger alert-error">
                        <a href="#" class="close" data-dismiss="alert">&times;</a>
                        <strong>Error!</strong> <?=$error_message?>
                    </div>
                    <? } ?>
                </div>
                <div class="col-md-12">
                    <h3> Add a Student </h3>
                    <form class="form-inline" method="post" action="server/sql.php">
                        <div class="form-group">
                            <label for="exampleInputName2">Name</label>
                            <input type="text" class="form-control" name="add_student_name" placeholder="Rehan Rasool" required>
                        </div>
                        <button type="submit" class="btn btn-default">Add</button>
                    </form>
                </div>
                <div class="col-md-12">
                    <h3> Delete a Student </h3>
                    <form class="form-inline" method="post" action="server/sql.php">
                        <div class="form-group">
                            <label for="exampleInputName2">ID</label>
                            <input type="number" class="form-control" name="delete_student_name" placeholder="12345678" required>
                        </div>
                        <button type="submit" class="btn btn-default">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Enrolled Section -->
    <section id="enrolled" class="gray_background">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h3> Enrolled </h3>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>
                                    Student
                                </th>
                                <th>
                                    Course
                                </th>
                                <th>
                                    Status
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <? foreach ($enrolled_data as $row){ ?>
                            <tr>

                                <!--<td><?=$row['student']?></td>-->
                                <td><?=$student_name_lookup[$row['student']]?></td>
                                <td><?=$row['course']?></td>
                                <td><?=$row['credit_status']?></td>
                            </tr>
                            <? } ?>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-12">
                    <? if ($message_section == 'enrolled' && $success_message != 'none') { ?>
                    <div class="alert alert-success">
                        <a href="#" class="close" data-dismiss="alert">&times;</a>
                        <strong>Success!</strong> <?=$success_message?>
                    </div>
                    <? } ?>
                    <? if ($message_section == 'enrolled' && $error_message != 'none') { ?>
                    <div class="alert alert-danger alert-error">
                        <a href="#" class="close" data-dismiss="alert">&times;</a>
                        <strong>Error!</strong> <?=$error_message?>
                    </div>
                    <? } ?>
                </div>
                <div class="col-md-12">
                    <h3> Enroll a Student </h3>
                    <form class="form-inline" method="post" action="server/sql.php">
                        <div class="form-group">
                            <label for="exampleInputName2">Name</label>
                            <select class="form-control" name="enroll_student_name" required>
                                <option value=""></option>
                                <? foreach ($students_data as $row){ ?>
                                <option value="<?=$row['id']?>"><?=$row['name']?></option>
                                <?}?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputName2">Course</label>
                            <select class="form-control" name="enroll_course_name" required>
                                <option value=""></option>
                                <? foreach ($course_data as $row){ ?>
                                <option value="<?=$row['name']?>"><?=$row['name']?></option>
                                <?}?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputName2">Status</label>
                            <select class="form-control" name="enroll_student_status" required>
                                <option value=""></option>
                                <option value="ugrad">ugrad</option>
                                <option value="grad">grad</option>
                                <option value="non-credit">non-credit</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-default">Enroll</button>
                    </form>
                </div>
                <div class="col-md-12">
                    <h3> Withdraw a Student </h3>
                    <form class="form-inline" method="post" action="server/sql.php">
                        <div class="form-group">
                            <label for="exampleInputName2">Name</label>
                            <select class="form-control" name="withdraw_student_name" required>
                                <option value=""></option>
                                <? foreach ($students_data as $row){ ?>
                                <option value="<?=$row['id']?>"><?=$row['name']?></option>
                                <?}?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputName2">Course</label>
                            <select class="form-control" name="withdraw_course_name" required>
                                <option value=""></option>
                                <? foreach ($course_data as $row){ ?>
                                <option value="<?=$row['name']?>"><?=$row['name']?></option>
                                <?}?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-default">Withdraw</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- MajorsIn Section -->
    <section id="majors">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h3> MajorsIn </h3>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>
                                    Student
                                </th>
                                <th>
                                    Department
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <? foreach ($majors_data as $row){ ?>
                            <tr>

                                <td><?=$student_name_lookup[$row['student']]?></td>
                                <td><?=$row['dept']?></td>
                            </tr>
                            <? } ?>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-12">
                    <? if ($message_section == 'majors' && $success_message != 'none') { ?>
                    <div class="alert alert-success">
                        <a href="#" class="close" data-dismiss="alert">&times;</a>
                        <strong>Success!</strong> <?=$success_message?>
                    </div>
                    <? } ?>
                    <? if ($message_section == 'majors' && $error_message != 'none') { ?>
                    <div class="alert alert-danger alert-error">
                        <a href="#" class="close" data-dismiss="alert">&times;</a>
                        <strong>Error!</strong> <?=$error_message?>
                    </div>
                    <? } ?>
                </div>
                <div class="col-md-12">
                    <h3> Add Student Major </h3>
                    <form class="form-inline" method="post" action="server/sql.php">
                        <div class="form-group">
                            <label for="exampleInputName2">Name</label>
                            <select class="form-control" name="add_major_student_name" required>
                                <option value=""></option>
                                <? foreach ($students_data as $row){ ?>
                                <option value="<?=$row['id']?>"><?=$row['name']?></option>
                                <?}?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputName2">Major</label>
                            <select class="form-control" name="add_major_student_major" required>
                                <option value=""></option>
                                <? foreach ($department_data as $row){ ?>
                                <option value="<?=$row['name']?>"><?=$row['name']?></option>
                                <?}?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-default">Add</button>
                    </form>
                </div>
                <div class="col-md-12">
                    <h3> Drop Student Major </h3>
                    <form class="form-inline" method="post" action="server/sql.php">
                        <div class="form-group">
                            <label for="exampleInputName2">Name</label>
                            <select class="form-control" name="drop_major_student_name" required>
                                <option value=""></option>
                                <? foreach ($students_data as $row){ ?>
                                <option value="<?=$row['id']?>"><?=$row['name']?></option>
                                <?}?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputName2">Major</label>
                            <select class="form-control" name="drop_major_student_major" required>
                                <option value=""></option>
                                <? foreach ($department_data as $row){ ?>
                                <option value="<?=$row['name']?>"><?=$row['name']?></option>
                                <?}?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-default">Drop</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Department Section -->
    <section id="department" class="gray_background">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h3> Departments </h3>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>
                                    Name
                                </th>
                                <th>
                                    Office
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <? foreach ($department_data as $row){ ?>
                            <tr>

                                <td><?=$row['name']?></td>
                                <td><?=$row['office']?></td>
                            </tr>
                            <? } ?>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-12">
                    <? if ($message_section == 'department' && $success_message != 'none') { ?>
                    <div class="alert alert-success">
                        <a href="#" class="close" data-dismiss="alert">&times;</a>
                        <strong>Success!</strong> <?=$success_message?>
                    </div>
                    <? } ?>
                    <? if ($message_section == 'department' && $error_message != 'none') { ?>
                    <div class="alert alert-danger alert-error">
                        <a href="#" class="close" data-dismiss="alert">&times;</a>
                        <strong>Error!</strong> <?=$error_message?>
                    </div>
                    <? } ?>
                </div>
                <div class="col-md-12">
                    <h3> Add Department </h3>
                    <form class="form-inline" method="post" action="server/sql.php">
                        <div class="form-group">
                            <label for="exampleInputName2">Name</label>
                            <input type="text" class="form-control" name="add_department_name" placeholder="Computer Science" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputName2">Office</label>
                            <input type="text" class="form-control" name="add_department_office" placeholder="BP326" required>
                        </div>
                        <button type="submit" class="btn btn-default">Add</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Course Section -->
    <section id="course">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h3> Courses </h3>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>
                                    Name
                                </th>
                                <th>
                                    Start Time
                                </th>
                                <th>
                                    End Time
                                </th>
                                <th>
                                    Room
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <? foreach ($course_data as $row){ ?>
                            <tr>

                                <td><?=$row['name']?></td>
                                <td><?=$row['start_time']?></td>
                                <td><?=$row['end_time']?></td>
                                <td><?=(isset($room_name_lookup[$row['room']]))? $room_name_lookup[$row['room']] : 'No Room Assigned'?></td>
                            </tr>
                            <? } ?>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-12">
                    <? if ($message_section == 'course' && $success_message != 'none') { ?>
                    <div class="alert alert-success">
                        <a href="#" class="close" data-dismiss="alert">&times;</a>
                        <strong>Success!</strong> <?=$success_message?>
                    </div>
                    <? } ?>
                    <? if ($message_section == 'course' && $error_message != 'none') { ?>
                    <div class="alert alert-danger alert-error">
                        <a href="#" class="close" data-dismiss="alert">&times;</a>
                        <strong>Error!</strong> <?=$error_message?>
                    </div>
                    <? } ?>
                </div>
                <div class="col-md-12">
                    <h3> Add a Course </h3>
                    <form class="form-inline" method="post" action="server/sql.php">
                        <div class="form-group">
                            <label for="exampleInputName2">Name</label>
                            <input type="text" class="form-control" name="add_course_name" placeholder="CS220" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputName2">Start</label>
                            <input type="text" class="form-control" name="add_course_start" placeholder="13:15:00" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputName2">End</label>
                            <input type="text" class="form-control" name="add_course_end" placeholder="14:40:00" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputName2">Room</label>
                            <select class="form-control" name="add_course_room" required>
                                <option value=""></option>
                                <? foreach ($room_data as $row){ ?>
                                <option value="<?=$row['id']?>"><?=$row['name']?></option>
                                <?}?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-default">Add</button>
                    </form>
                </div>
                <div class="col-md-12">
                    <h3> Delete a Course </h3>
                    <form class="form-inline" method="post" action="server/sql.php">
                        <div class="form-group">
                            <label for="exampleInputName2">Name</label>
                            <select class="form-control" name="delete_course_name" required>
                                <option value=""></option>
                                <? foreach ($course_data as $row){ ?>
                                <option value="<?=$row['name']?>"><?=$row['name']?></option>
                                <?}?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-default">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Room Section -->
    <section id="room" class="gray_background">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h3> Rooms </h3>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>
                                    ID
                                </th>
                                <th>
                                    Name
                                </th>
                                <th>
                                    Capacity
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <? foreach ($room_data as $row){ ?>
                            <tr>

                                <td><?=$row['id']?></td>
                                <td><?=$row['name']?></td>
                                <td><?=$row['capacity']?></td>
                            </tr>
                            <? } ?>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-12">
                    <? if ($message_section == 'room' && $success_message != 'none') { ?>
                    <div class="alert alert-success">
                        <a href="#" class="close" data-dismiss="alert">&times;</a>
                        <strong>Success!</strong> <?=$success_message?>
                    </div>
                    <? } ?>
                    <? if ($message_section == 'room' && $error_message != 'none') { ?>
                    <div class="alert alert-danger alert-error">
                        <a href="#" class="close" data-dismiss="alert">&times;</a>
                        <strong>Error!</strong> <?=$error_message?>
                    </div>
                    <? } ?>
                </div>
                <div class="col-md-12">
                    <h3> Add Room </h3>
                    <form class="form-inline" method="post" action="server/sql.php">
                        <div class="form-group">
                            <label for="exampleInputName2">Name</label>
                            <input type="text" class="form-control" name="add_room_name" placeholder="BP326" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputName2">Capacity</label>
                            <input type="number" class="form-control" name="add_room_capacity" placeholder="25" required>
                        </div>
                        <button type="submit" class="btn btn-default">Add</button>
                    </form>
                </div>
                <div class="col-md-12">
                    <h3> Delete Room </h3>
                    <form class="form-inline" method="post" action="server/sql.php">
                        <div class="form-group">
                            <label for="exampleInputName2">Name</label>
                            <select class="form-control" name="delete_room_name" required>
                                <option value=""></option>
                                <? foreach ($room_data as $row){ ?>
                                <option value="<?=$row['name']?>"><?=$row['name']?></option>
                                <?}?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-default">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Scrolling Nav JavaScript -->
    <script src="js/jquery.easing.min.js"></script>
    <script src="js/scrolling-nav.js"></script>

</body>

</html>

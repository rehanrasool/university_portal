<?php
	session_start();

    if (isset($_POST['add_student_name'])) {
    	die(add_student());
    }

    if (isset($_POST['delete_student_name'])) {
    	die(delete_student());
    }

    if (isset($_POST['enroll_student_name']) && isset($_POST['enroll_course_name']) && isset($_POST['enroll_student_status'])) {
    	die(enroll_student());
    }

    if (isset($_POST['withdraw_student_name']) && isset($_POST['withdraw_course_name'])) {
    	die(withdraw_student());
    }

    if (isset($_POST['add_major_student_name']) && isset($_POST['add_major_student_major'])) {
    	die(add_major());
    }

    if (isset($_POST['drop_major_student_name']) && isset($_POST['drop_major_student_major'])) {
    	die(drop_major());
    }

    if (isset($_POST['add_department_name']) && isset($_POST['add_department_office'])) {
    	die(add_department());
    }

    if (isset($_POST['add_course_name']) && isset($_POST['add_course_start']) && isset($_POST['add_course_end']) && isset($_POST['add_course_room'])) {
    	die(add_course());
    }

    if (isset($_POST['delete_course_name'])) {
    	die(delete_course());
    }

    if (isset($_POST['add_room_name']) && isset($_POST['add_room_capacity'])) {
    	die(add_room());
    }

    if (isset($_POST['delete_room_name'])) {
    	die(delete_room());
    }

    function get_data_from_table($table_name) {
        $db = mysql_connect('localhost','bluecu6_rehan','.dehari.');
		mysql_select_db('bluecu6_rehan_university', $db);

		$return_value = json_encode(-1);

        $query = "SELECT * FROM " . $table_name . ";";
        $result = mysql_query($query, $db);
       
		if (!$result) {
		    $return_value  = 'Invalid query: ' . mysql_error() . "\n";
		    $return_value .= 'Whole query: ' . $query;
		    
		} else {
            $return_value = array();
            while ($row = mysql_fetch_assoc($result))
                    $return_value[] = $row;
		}

    	return $return_value;
	}

    function add_student () {
	    // validate data
	    if( !isset($_POST['add_student_name'])) {
	        die('We are sorry, but there appears to be a problem with the form you submitted.');       
	    }

        $db = mysql_connect('localhost','bluecu6_rehan','.dehari.');
		mysql_select_db('bluecu6_rehan_university', $db);

		$return_value = json_encode(-1);

        $query = 'INSERT INTO `Student`(`name`) VALUES ("' . $_POST['add_student_name'] . '");';
        $result = mysql_query($query, $db);
       
		if (!$result) {
		    $return_value  = 'Invalid query: ' . mysql_error() . "\n";
		    $return_value .= 'Whole query: ' . $query;

		    $_SESSION['message_section'] = 'intro';
			$_SESSION['success_message'] = 'none';
			$_SESSION['error_message'] = $return_value;
		    
		} else {
			if (mysql_affected_rows() > 0) {
				$_SESSION['message_section'] = 'intro';
				$_SESSION['error_message'] = 'none';
				$_SESSION['success_message'] = 'Student Successfully Added!';
			} else {
				$_SESSION['message_section'] = 'intro';
				$_SESSION['error_message'] = 'Student could not be added!';
				$_SESSION['success_message'] = 'none';
			}
		}

		session_write_close(); 
        header('Location: ../index.php');

    	return $return_value;
	}

    function delete_student () {
	    // validate data
	    if( !isset($_POST['delete_student_name'])) {
	        die('We are sorry, but there appears to be a problem with the form you submitted.');       
	    }

        $db = mysql_connect('localhost','bluecu6_rehan','.dehari.');
		mysql_select_db('bluecu6_rehan_university', $db);

		$return_value = json_encode(-1);

        $query = 'DELETE FROM `Student` WHERE id = "' . $_POST['delete_student_name'] . '";';
        $result = mysql_query($query, $db);

        $rows_affected = mysql_affected_rows();

        $query2 = 'DELETE FROM `Enrolled` WHERE student = "' . $_POST['delete_student_name'] . '";';
        $result2 = mysql_query($query2, $db);

        $query3 = 'DELETE FROM `MajorsIn` WHERE student = "' . $_POST['delete_student_name'] . '";';
        $result3 = mysql_query($query3, $db);
       
		if (!$result) {
		    $return_value  = 'Invalid query: ' . mysql_error() . "\n";
		    $return_value .= 'Whole query: ' . $query;

		    $_SESSION['message_section'] = 'intro';
			$_SESSION['success_message'] = 'none';
			$_SESSION['error_message'] = $return_value;
		} else {
			if ($rows_affected > 0) {
				$_SESSION['message_section'] = 'intro';
				$_SESSION['error_message'] = 'none';
				$_SESSION['success_message'] = 'Student Successfully Deleted!';
			} else {
				$_SESSION['message_section'] = 'intro';
				$_SESSION['success_message'] = 'none';
				$_SESSION['error_message'] = 'There is no student with that name!';
			}
			
		}

		session_write_close(); 
        header('Location: ../index.php');

    	return $return_value;
	}


    function enroll_student () {
	    // validate data
	    if( !isset($_POST['enroll_student_name']) && !isset($_POST['enroll_course_name']) && !isset($_POST['enroll_student_status'])) {
	        die('We are sorry, but there appears to be a problem with the form you submitted.');       
	    }

        $db = mysql_connect('localhost','bluecu6_rehan','.dehari.');
		mysql_select_db('bluecu6_rehan_university', $db);

		$return_value = json_encode(-1);

        $query = 'INSERT INTO `Enrolled`(`student`, `course`, `credit_status`) VALUES ("' . $_POST['enroll_student_name'] . '","' . $_POST['enroll_course_name'] . '","' . $_POST['enroll_student_status'] . '");';
        $result = mysql_query($query, $db);
       
		if (!$result) {
		    $return_value  = 'Invalid query: ' . mysql_error() . "\n";
		    $return_value .= 'Whole query: ' . $query;

		    $_SESSION['message_section'] = 'enrolled';
			$_SESSION['success_message'] = 'none';
			$_SESSION['error_message'] = $return_value;
		    
		} else {
			if (mysql_affected_rows() > 0) {
				$_SESSION['message_section'] = 'enrolled';
				$_SESSION['error_message'] = 'none';
				$_SESSION['success_message'] = 'Student Successfully Enrolled!';
			} else {
				$_SESSION['message_section'] = 'enrolled';
				$_SESSION['success_message'] = 'none';
				$_SESSION['error_message'] = 'Student could not be enrolled!';
			}
		}

		session_write_close(); 
        header('Location: ../index.php#enrolled');

    	return $return_value;
	}

    function withdraw_student () {
	    // validate data
	    if( !isset($_POST['withdraw_student_name']) && !isset($_POST['withdraw_student_name'])) {
	        die('We are sorry, but there appears to be a problem with the form you submitted.');       
	    }

        $db = mysql_connect('localhost','bluecu6_rehan','.dehari.');
		mysql_select_db('bluecu6_rehan_university', $db);

		$return_value = json_encode(-1);

        $query = 'DELETE FROM `Enrolled` WHERE student = "' . $_POST['withdraw_student_name'] . '" AND course  = "' . $_POST['withdraw_course_name'] . '";';
        $result = mysql_query($query, $db);
       
		if (!$result) {
		    $return_value  = 'Invalid query: ' . mysql_error() . "\n";
		    $return_value .= 'Whole query: ' . $query;

		    $_SESSION['message_section'] = 'enrolled';
			$_SESSION['success_message'] = 'none';
			$_SESSION['error_message'] = $return_value;

		} else {
			if (mysql_affected_rows() > 0) {
				$_SESSION['message_section'] = 'enrolled';
				$_SESSION['error_message'] = 'none';
				$_SESSION['success_message'] = 'Student Successfully Withdrawn!';
			} else {
				$_SESSION['message_section'] = 'enrolled';
				$_SESSION['success_message'] = 'none';
				$_SESSION['error_message'] = 'Student is not enrolled for that course!';
			}
		}

		session_write_close(); 
        header('Location: ../index.php#enrolled');

    	return $return_value;
	}

    function add_major () {
	    // validate data
	    if( !isset($_POST['add_major_student_name']) && !isset($_POST['add_major_student_major'])) {
	        die('We are sorry, but there appears to be a problem with the form you submitted.');       
	    }

        $db = mysql_connect('localhost','bluecu6_rehan','.dehari.');
		mysql_select_db('bluecu6_rehan_university', $db);

		$return_value = json_encode(-1);

        $query = 'INSERT INTO `MajorsIn`(`student`, `dept`) VALUES ("' . $_POST['add_major_student_name'] . '","' . $_POST['add_major_student_major'] . '");';
        $result = mysql_query($query, $db);
       
		if (!$result) {
		    $return_value  = 'Invalid query: ' . mysql_error() . "\n";
		    $return_value .= 'Whole query: ' . $query;

		    $_SESSION['message_section'] = 'majors';
			$_SESSION['success_message'] = 'none';
			$_SESSION['error_message'] = $return_value;

		} else {
			if (mysql_affected_rows() > 0) {
				$_SESSION['message_section'] = 'majors';
				$_SESSION['error_message'] = 'none';
				$_SESSION['success_message'] = 'Major Successfully Added!';
			} else {
				$_SESSION['message_section'] = 'majors';
				$_SESSION['success_message'] = 'none';
				$_SESSION['error_message'] = 'Student is not majoring in that!';
			}
		}

		session_write_close(); 
		header('Location: ../index.php#majors');

    	return $return_value;
	}

    function drop_major () {
	    // validate data
	    if( !isset($_POST['drop_major_student_name']) && !isset($_POST['drop_major_student_major'])) {
	        die('We are sorry, but there appears to be a problem with the form you submitted.');       
	    }

        $db = mysql_connect('localhost','bluecu6_rehan','.dehari.');
		mysql_select_db('bluecu6_rehan_university', $db);

		$return_value = json_encode(-1);

        $query = 'DELETE FROM `MajorsIn` WHERE student = "' . $_POST['drop_major_student_name'] . '" AND dept  = "' . $_POST['drop_major_student_major'] . '";';
        $result = mysql_query($query, $db);
       
		if (!$result) {
		    $return_value  = 'Invalid query: ' . mysql_error() . "\n";
		    $return_value .= 'Whole query: ' . $query;

		    $_SESSION['message_section'] = 'majors';
			$_SESSION['success_message'] = 'none';
			$_SESSION['error_message'] = $return_value;

		} else {
			if (mysql_affected_rows() > 0) {
				$_SESSION['message_section'] = 'majors';
				$_SESSION['error_message'] = 'none';
				$_SESSION['success_message'] = 'Major Successfully Dropped!';
			} else {
				$_SESSION['message_section'] = 'majors';
				$_SESSION['success_message'] = 'none';
				$_SESSION['error_message'] = 'Major could not be dropped!';
			}
		}

		session_write_close(); 
		header('Location: ../index.php#majors');

    	return $return_value;
	}

    function add_department () {
	    // validate data
	    if( !isset($_POST['add_department_name']) && !isset($_POST['add_department_office'])) {
	        die('We are sorry, but there appears to be a problem with the form you submitted.');       
	    }

        $db = mysql_connect('localhost','bluecu6_rehan','.dehari.');
		mysql_select_db('bluecu6_rehan_university', $db);

		$return_value = json_encode(-1);

        $query = 'INSERT INTO `Department`(`name`, `office`) VALUES ("' . $_POST['add_department_name'] . '","' . $_POST['add_department_office'] . '");';
        $result = mysql_query($query, $db);
       
		if (!$result) {
		    $return_value  = 'Invalid query: ' . mysql_error() . "\n";
		    $return_value .= 'Whole query: ' . $query;

		    $_SESSION['message_section'] = 'department';
			$_SESSION['success_message'] = 'none';
			$_SESSION['error_message'] = $return_value;

		} else {
			if (mysql_affected_rows() > 0) {
				$_SESSION['message_section'] = 'department';
				$_SESSION['error_message'] = 'none';
				$_SESSION['success_message'] = 'Department Successfully Added!';
			} else {
				$_SESSION['message_section'] = 'department';
				$_SESSION['success_message'] = 'none';
				$_SESSION['error_message'] = 'Department could not be added!';
			}
		}

		session_write_close(); 
		header('Location: ../index.php#department');

    	return $return_value;
	}

    function add_course () {
	    // validate data
	    if( !isset($_POST['add_course_name']) && !isset($_POST['add_course_start']) && !isset($_POST['add_course_end']) && !isset($_POST['add_course_room'])) {
	        die('We are sorry, but there appears to be a problem with the form you submitted.');       
	    }

        $db = mysql_connect('localhost','bluecu6_rehan','.dehari.');
		mysql_select_db('bluecu6_rehan_university', $db);

		$return_value = json_encode(-1);

        $query = 'INSERT INTO `Course`(`name`, `start_time`, `end_time`, `room`) VALUES ("' . $_POST['add_course_name'] . '","' . $_POST['add_course_start'] . '","' . $_POST['add_course_end'] . '","' . $_POST['add_course_room'] . '");';
        $result = mysql_query($query, $db);
       
		if (!$result) {
		    $return_value  = 'Invalid query: ' . mysql_error() . "\n";
		    $return_value .= 'Whole query: ' . $query;

		    $_SESSION['message_section'] = 'course';
			$_SESSION['success_message'] = 'none';
			$_SESSION['error_message'] = $return_value;

		} else {
			if (mysql_affected_rows() > 0) {
				$_SESSION['message_section'] = 'course';
				$_SESSION['error_message'] = 'none';
				$_SESSION['success_message'] = 'Course Successfully Added!';
			} else {
				$_SESSION['message_section'] = 'course';
				$_SESSION['success_message'] = 'none';
				$_SESSION['error_message'] = 'Course could not be added!';
			}
		}

		session_write_close(); 
		header('Location: ../index.php#course');

    	return $return_value;
	}

    function delete_course () {
	    // validate data
	    if( !isset($_POST['delete_course_name'])) {
	        die('We are sorry, but there appears to be a problem with the form you submitted.');       
	    }

        $db = mysql_connect('localhost','bluecu6_rehan','.dehari.');
		mysql_select_db('bluecu6_rehan_university', $db);

		$return_value = json_encode(-1);

        $query = 'DELETE FROM `Course` WHERE name = "' . $_POST['delete_course_name'] . '";';
        $result = mysql_query($query, $db);

        $rows_affected = mysql_affected_rows();

        $query2 = 'DELETE FROM `Enrolled` WHERE course  = "' . $_POST['delete_course_name'] . '";';
        $result2 = mysql_query($query2, $db);
       
		if (!$result) {
		    $return_value  = 'Invalid query: ' . mysql_error() . "\n";
		    $return_value .= 'Whole query: ' . $query;

		    $_SESSION['message_section'] = 'course';
			$_SESSION['success_message'] = 'none';
			$_SESSION['error_message'] = $return_value;

		} else {
			if ($rows_affected) {
				$_SESSION['message_section'] = 'course';
				$_SESSION['error_message'] = 'none';
				$_SESSION['success_message'] = 'Course Successfully Deleted!';
			} else {
				$_SESSION['message_section'] = 'course';
				$_SESSION['success_message'] = 'none';
				$_SESSION['error_message'] = 'Course could not be deleted!';
			}
		}

		session_write_close(); 
		header('Location: ../index.php#course');

    	return $return_value;
	}

    function add_room () {
	    // validate data
	    if( !isset($_POST['add_room_name']) && !isset($_POST['add_room_capacity'])) {
	        die('We are sorry, but there appears to be a problem with the form you submitted.');       
	    }

        $db = mysql_connect('localhost','bluecu6_rehan','.dehari.');
		mysql_select_db('bluecu6_rehan_university', $db);

		$return_value = json_encode(-1);

        $query = 'INSERT INTO `Room`(`name`, `capacity`) VALUES ("' . $_POST['add_room_name'] . '","' . $_POST['add_room_capacity'] . '");';
        $result = mysql_query($query, $db);
       
		if (!$result) {
		    $return_value  = 'Invalid query: ' . mysql_error() . "\n";
		    $return_value .= 'Whole query: ' . $query;

		    $_SESSION['message_section'] = 'room';
			$_SESSION['success_message'] = 'none';
			$_SESSION['error_message'] = $return_value;

		} else {
			if (mysql_affected_rows() > 0) {
				$_SESSION['message_section'] = 'room';
				$_SESSION['error_message'] = 'none';
				$_SESSION['success_message'] = 'Room Successfully Added!';
			} else {
				$_SESSION['message_section'] = 'room';
				$_SESSION['success_message'] = 'none';
				$_SESSION['error_message'] = 'Room could not be added!';
			}
		}

		session_write_close(); 
		header('Location: ../index.php#room');

    	return $return_value;
	}

    function delete_room () {
	    // validate data
	    if( !isset($_POST['delete_room_name'])) {
	        die('We are sorry, but there appears to be a problem with the form you submitted.');       
	    }

        $db = mysql_connect('localhost','bluecu6_rehan','.dehari.');
		mysql_select_db('bluecu6_rehan_university', $db);

		$return_value = json_encode(-1);

        $query = 'DELETE FROM `Room` WHERE name = "' . $_POST['delete_room_name'] . '";';
        $result = mysql_query($query, $db);
       
		if (!$result) {
		    $return_value  = 'Invalid query: ' . mysql_error() . "\n";
		    $return_value .= 'Whole query: ' . $query;

		    $_SESSION['message_section'] = 'room';
			$_SESSION['success_message'] = 'none';
			$_SESSION['error_message'] = $return_value;

		} else {
			if (mysql_affected_rows() > 0) {
				$_SESSION['message_section'] = 'room';
				$_SESSION['error_message'] = 'none';
				$_SESSION['success_message'] = 'Room Successfully Deleted!';
			} else {
				$_SESSION['message_section'] = 'room';
				$_SESSION['success_message'] = 'none';
				$_SESSION['error_message'] = 'Room could not be deleted!';
			}
		}

		session_write_close(); 
		header('Location: ../index.php#room');

    	return $return_value;
	}
?>
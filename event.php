<?php
	/**
	 * sends mail submitted from the contact form
	 */

    /*
        EDIT BELOW
     */
    $to_Email       = "miguel@pcuervo.com"; //Replace with your email address
    $subject        = 'Email sent from Jam site - Event'; //Subject line for emails
    /*
        EDIT ABOVE
     */

	if(!isset($_POST["competitor-name"]) || !isset($_POST["competitor-lastname"]) || !isset($_POST["competitor-email"]) ) {
	    $output = json_encode(array('type'=>'error', 'text' => 'Input fields are empty!'));
	    die($output);
	}

	//additional validation
    $user_Name        = filter_var($_POST["competitor-name"], FILTER_SANITIZE_STRING);
    $user_Lastname    = filter_var($_POST["competitor-lastname"], FILTER_SANITIZE_STRING);
    $user_Email       = filter_var($_POST["competitor-email"], FILTER_SANITIZE_EMAIL);

    if(strlen($user_Name)<4) {
        $output = json_encode(array('type'=>'error', 'text' => 'Name is too short or empty!'));
        die($output);
    }
    if(strlen($user_Lastname)<4) {
        $output = json_encode(array('type'=>'error', 'text' => 'Last Name is too short or empty!'));
        die($output);
    }

    //proceed with PHP email.
    $headers = "From: $user_Email\n" .
    "Reply-To: $user_Email\n" .
    "MIME-Version: 1.0\n" .
    "Content-Type: text/html\n" .
    "X-Mailer: PHP/" . phpversion();

    $sentMail = @mail($to_Email, $subject, ' <p><strong>Name:</strong></p>'.$user_Name .' <p><strong>Last Name:</strong></p>'.$user_Lastname  .' <p><strong>Email:</strong></p>'.$user_Email, $headers);

    if(!$sentMail) {
        $output = json_encode(array('type'=>'error', 'text' => 'Server error, could not send email. Sorry for the inconvenience, try again please.'));
        die($output);
    } else {
        $output = json_encode(array('type'=>'success', 'text' => 'Message successfully sent!'));
        die($output);
    }
?>
<?php
	/**
	 * sends mail submitted from the contact form
	 */
    
    /*
        EDIT BELOW
     */
    $to_Email       = "hello@wejam.xyz"; //Replace with your email address
    $subject        = 'Email sent from Jam site'; //Subject line for emails
    /*
        EDIT ABOVE
     */

	if(!isset($_POST["name"]) || !isset($_POST["email"]) || !isset($_POST["message"])) {
	    $output = json_encode(array('type'=>'error', 'text' => 'Input fields are empty!'));
	    die($output);
	}

	//additional validation
    $user_Name        = filter_var($_POST["name"], FILTER_SANITIZE_STRING);
    $user_Email       = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    $user_Message     = filter_var($_POST["message"], FILTER_SANITIZE_STRING);

    if(strlen($user_Name)<4) {
        $output = json_encode(array('type'=>'error', 'text' => 'Name is too short or empty!'));
        die($output);
    }
    if(!filter_var($user_Email, FILTER_VALIDATE_EMAIL)) {
        $output = json_encode(array('type'=>'error', 'text' => 'Please enter a valid email!'));
        die($output);
    }

    //proceed with PHP email.
    $headers = "From: $user_Email\n" .
    "Reply-To: $user_Email\n" .
    "MIME-Version: 1.0\n" .
    "Content-Type: text/html\n" .
    "X-Mailer: PHP/" . phpversion();

    $sentMail = @mail($to_Email, $subject, $user_Message .' <p><strong>Name:</strong></p>'.$user_Name .' <p><strong>Email:</strong></p>'.$user_Email, $headers);
   
    if(!$sentMail) {
        $output = json_encode(array('type'=>'error', 'text' => 'Server error, could not send email. Sorry for the inconvenience.'));
        die($output);
    } else {
        $output = json_encode(array('type'=>'success', 'text' => 'Message successfully sent!'));
        die($output);
    }
?>
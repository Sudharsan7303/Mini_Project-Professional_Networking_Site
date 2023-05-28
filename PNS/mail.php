<?php
// Include PHPMailer
require_once('vendor/autoload.php');

// Create a new PHPMailer instance
$mail = new PHPMailer\PHPMailer\PHPMailer();

// Set the SMTP server details
$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = true;
$mail->Username = 'pnsuser7303@gmail.com';
$mail->Password = 'vltnowubkeaesjpa';
$mail->SMTPSecure = 'tls';
$mail->Port = 587;

// Set the sender and recipient email addresses
$mail->setFrom($_POST['email'], $_POST['name']);
$mail->addAddress('pnsad7303@gmail.com', 'Admin');

// Set the email subject and HTML content
$mail->Subject = 'New form submission';
$mail->isHTML(true);
$mail->Body = '<p>Name: ' . $_POST['name'] . '</p><p>Email: ' . $_POST['email'] . '</p><p>Category: ' . $_POST['category'] . '</p><p>Mobile: ' . $_POST['mobilenumber'] . '</p><p>Address: ' . $_POST['address'] . '</p><p>City: ' . $_POST['city'] . '</p><p>Experience: ' . $_POST['exp'] . '</p><h3>Profile picture ,Sample work image,Certifications are attached below:</h3>';

// Add the first image attachment
if (isset($_FILES['propic']) && $_FILES['propic']['error'] == UPLOAD_ERR_OK) {
	$image_path_1 = $_FILES['propic']['tmp_name'];
	$image_name_1 = $_FILES['propic']['name'];
	$mail->addAttachment($image_path_1, $image_name_1);
}

// Add the second image attachment
if (isset($_FILES['workimage']) && $_FILES['workimage']['error'] == UPLOAD_ERR_OK) {
	$image_path_2 = $_FILES['workimage']['tmp_name'];
	$image_name_2 = $_FILES['workimage']['name'];
	$mail->addAttachment($image_path_2, $image_name_2);
}
// Add the third image attachment
if (isset($_FILES['certification']) && $_FILES['certification']['error'] == UPLOAD_ERR_OK) {
	$image_path_3 = $_FILES['certification']['tmp_name'];
	$image_name_3 = $_FILES['certification']['name'];
	$mail->addAttachment($image_path_3, $image_name_3);
}

// Send the email with form data
if (!$mail->send()) {
    echo 'Error: ' . $mail->ErrorInfo;
} else {
    echo 'Email sent successfully!';
}
?>
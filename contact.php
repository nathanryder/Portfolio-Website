<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Nathan Ryder | Contact</title>
  <link rel="stylesheet" href="files/css/master.css">
  <link rel="stylesheet" href="files/bootstrap/bootstrap.min.css" >
</head>
<body style="background-color: #333">
  <?php include 'files/include/navbar.php'; ?>

  <center>
		<?php
		if (isset($_POST['submit'])) {
			if (isset($_POST['name']) && isset($_POST['email']) && sizeof(explode(" ", $_POST['msg'])) > 1) {
				$name = $_POST['name'];
				$email = $_POST['email'];
				$msg = $_POST['msg'];
				$send = "Name: " . $name . "\nEmail: " . $email . "\nMessage: " . wordwrap($msg, 70);


				mail("nathanryder16@@gmail.com", "Contact from nathanryder.ml", $send);
				?>
        <img width="20%" src="files/images/ThankYou.png" alt="">
				<p style="color: green; font-size: 25px;">Thank you for contacting me! I will get back to you as soon as possible.</p>
				<?php
			} else {
        header("Location: index.php#contact");
			}
		}
		?>
	</center>
</body>

<?php include("files/include/footer.php"); ?>

<script src="files/bootstrap/jquery.min.js"></script>
<script src="files/bootstrap/popper.min.js"></script>
<script src="files/bootstrap/bootstrap.min.js"></script>
</html>

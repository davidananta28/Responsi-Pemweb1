<?php
// app/views/auth/logout.php
// Arahkan langsung ke AuthController dengan action logout
header("Location: ../../controllers/AuthController.php?action=logout");
exit;

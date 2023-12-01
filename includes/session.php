<?php
session_start();
if (!isset($_SESSION['empid'])) {
    ?>
        <script>
            alert("Please login first");
            window.open('../index.php','_self');
        </script>
    <?php
}


?>
<?php
$company_name = "team_21";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to
        <?php echo $company_name; ?>
    </title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<?php include ("content/header.php") ?>

<body>
    <?php include ("content/navbar.php") ?>

    <main>
        <section id="welcome">
            <h1>Welcome to
                <?php echo $company_name; ?>
            </h1>
            <p>Welcome to team_21 startup. Currently, we are working on programming a Color-Coordination Generator for our customers.</p>

            <p>Thank you for visiting our landing page.</p>
        </section>

    </main>

    <?php include ("content/footer.php") ?>

    <script src="assets/js/main.js"></script>
</body>

</html>
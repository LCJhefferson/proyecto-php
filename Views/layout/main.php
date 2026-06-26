<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My proyecto MVC</title>
</head>
<body>
    <?php include 'Views/layout/header.php'; ?>

    <?php include 'Views/layout/nav.php'; ?>

    <main>
        <?php echo $contentView; ?> 
    </main>
    
    <?php include 'Views/layout/footer.php'; ?>

</body>
</html>

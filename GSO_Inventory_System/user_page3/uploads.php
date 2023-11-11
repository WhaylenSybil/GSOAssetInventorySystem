<?php
$uploadDirectory = './downloadables/'; // Directory where uploaded files will be stored
$uploadedFiles = [];

if (isset($_FILES['file'])) {
    $totalFiles = count($_FILES['file']['name']);
    
    for ($i = 0; $i < $totalFiles; $i++) {
        $filename = $_FILES['file']['name'][$i];
        $targetPath = $uploadDirectory . $filename;

        if (move_uploaded_file($_FILES['file']['tmp_name'][$i], $targetPath)) {
            $uploadedFiles[] = $filename;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>GSO Asset Inventory System</title>
    <meta content="width-device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="../bower_components/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../bower_components/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="bower_components/Ionicons/css/ionicons.min.css">
    <link rel="stylesheet" type="text/css" href="../dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="../dist/css/skins/skin-blue-light.min.css">

    <!-- Favicons -->
    <link  href="img/baguiologo.png" rel="icon">
    <link rel="apple-touch-icon" href="img/baguiologo.png">

</head>
<body>
    <main>
        <h2>Available Forms</h2>
        <div class="row">
            <?php foreach ($uploadedFiles as $file): ?>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-green"><i class="fa fa-files-o"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-number"><?php echo $file; ?></span>
                            <i class="fa fa-download"></i><a href="<?php echo $uploadDirectory . $file; ?>" class="small-box-footer" download>Click here to download</a>
                        </div>
                        <!-- info box content -->
                    </div>
                    <!-- info box -->
                </div>
            <?php endforeach; ?>
        </div>
    </main>
    <footer>
        <p>&copy; <?php echo date('Y'); ?> Your Website Name</p>
    </footer>
</body>
</html>
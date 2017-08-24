<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>File Parse</title>

        <!-- Bootstrap Core CSS -->
        <link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css" type="text/css">

        <!-- DataTables CSS -->
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/t/dt/dt-1.10.11/datatables.min.css"/>

        <!-- Custom CSS -->
        <link rel="stylesheet" href="assets/css/styles.css" type="text/css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>

    <body>
        <header>
            <div class="container">
                <h1>
                    File Parse
                </h1>
            </div>
        </header>

        <section id="main">
            <div class="container">
                <div class="well">
                    <form action="functions/process.php" method="post">
                        <div class="form-group">
                            <label for="parse_source">What do we parse?</label>

                            <select name="parse_source" id="parse_source" class="form-control">
                                <option value="">-- Select --</option>

                                <?php
                                foreach (scandir("uploads") as $filename) {
                                    if (!empty($filename) && !in_array($filename, [".", ".."])) {
                                        echo "<option value=\"{$filename}\">{$filename}</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>

                        <div class="alert alert-warning" role="alert">
                            Attention! Do not close the page, browser or stop the script after pressing the submit button!
                        </div>

                        <div class="form-group">
                            <input type="submit" class="btn btn-primary">
                        </div>
                    </form>
                </div>
            </div>
        </section>

        <div id="loader"><img src="assets/img/loader.gif" /></div>

        <!-- jQuery -->
        <script src="assets/vendor/jquery/jquery-1.11.2.min.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="assets/vendor/bootstrap/js/bootstrap.min.js"></script>

        <!-- DataTables JavaScript -->
        <script type="text/javascript" src="https://cdn.datatables.net/t/dt/dt-1.10.11/datatables.min.js"></script>

        <!-- Custom JavaScript -->
        <script src="assets/js/script.js"></script>
    </body>
</html>

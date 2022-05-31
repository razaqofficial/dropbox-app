<html>
    <head>
        <meta charset="utf-8">
        <title>Dropbox App</title>

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    </head>

<body>
<div class="container">
    <h2>Dropbox Trial project</h2>

    <div class="row">
        <div class="col-11">
            <ul class="list-group">
                <?php foreach ($items as $data) { ?>
                    <li class="list-group-item"><?php echo $data['name']; ?> <a class="btn btn-info btn-sm" href="/download?file_name=<?php echo $data['name'] ?>">download</a></li>
                <?php } ?>
            </ul>
        </div>
    </div>
</div>
</body>
</html>
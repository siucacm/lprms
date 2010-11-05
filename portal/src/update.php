<html>
    <head>
        <title>LPRMS Updater Script</title>
    </head>

    <body>
        <a href="?update=1">UPDATE</a>
        <?php if (isset($_GET['update'])) { ?>
        <br /><br />
        Update results:
        <pre><?php
            passthru('svn update /srv/http/www/salukilan.tk/htdocs');
            passthru('chmod g+w -R /srv/http/www/salukilan.tk/htdocs');
        ?></pre><?php } ?>
        <br /><br />
        Revision information:
        <pre><?php passthru('svn info /srv/http/www/salukilan.tk/htdocs'); ?></pre>
    </body>
</html>

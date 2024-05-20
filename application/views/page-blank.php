<!DOCTYPE html>
<html lang="pt-br">
    <head>

      <?php echo $head; ?>
      <?
      if (isset($extra_head)) {
        foreach ($extra_head as $extra_head_script)
        {
        echo $extra_head_script;
        }
      }
      ?>

    </head>


    <body>

        <?php echo $content; ?>

        <?php echo $scripts; ?>
        <?
        if (isset($extra_scripts)) {
          foreach ($extra_scripts as $extra_script)
          {
          echo $extra_script;
          }
        }
        ?>
    
    </body>
</html>

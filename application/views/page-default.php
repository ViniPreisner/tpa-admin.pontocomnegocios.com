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
      <?
      if (isset($extra_css)) {
        foreach ($extra_css as $extra_css_script)
        {
        echo $extra_css_script;
        }
      }
      ?>

    </head>


    <body>

        <!-- Aside Start-->
        <aside class="left-panel">

            <?php echo $brand; ?>
        
            <?php echo $aside; ?>


        <?php echo $header; ?>


            <!-- Page Content Start -->
            <!-- ================== -->

            <div class="wraper container-fluid">

              <?php echo $content; ?>

            </div>
            <!-- Page Content Ends -->
            <!-- ================== -->

           <?php echo $footer; ?>



        </section>
        <!-- Main Content Ends -->
        


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

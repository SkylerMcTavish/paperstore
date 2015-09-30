<?php

  set_time_limit(0);
  ini_set("max_execution_time", 0);
  ini_set('memory_limit', '2500M');


  require 'init.php';

  $action = ( isset($_REQUEST['action']) ? $_REQUEST['action'] : NULL );


  if ($action != NULL)
  {
      require_once DIRECTORY_CLASS . "class.admin.lst.php";



      $list = new AdminList($action);

      if (isset($_POST['filterIdx']) && $_POST['filterIdx'] != '' && isset($_POST['filterVal']) && $_POST['filterVal'] != '')
      {
          $list->set_filter($_POST['filterIdx'], $_POST['filterVal']);
          $list->fidx = $_POST['filterIdx'];
          $list->fval = $_POST['filterVal'];
      }

      if (isset($_POST['extraFilterIdx']) && $_POST['extraFilterIdx'] != '' && isset($_POST['extraFilterVal']) && $_POST['extraFilterVal'] != '')
      {
          $list->set_filter($_POST['extraFilterIdx'], $_POST['extraFilterVal']);
          $list->exfidx = $_POST['extraFilterIdx'];
          $list->exfval = $_POST['extraFilterVal'];
      }


      $xls = $list->get_list_xls();
  }
?>
<?
    ob_start (); // start buffering

    include_once("config.php");
    include_once("includes/db.php");
    include_once("includes/sessionManager.php");
    include_once("includes/functions.php");
    include_once("includes/libs/PhpGridder.php");
    
    $sessionManager = new SessionManager();
?>

<?
    $page = isset($_GET["page"]) ? $_GET["page"]  : "main";
    $pageContent = getView($page);
    $pageLogic = getViewModel($page);
    $showPageContent = true;
    $error = null;
    $message = null;
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <title><!--TITLE--></title>
    <meta charset="<?=$website_charset?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<!--DESCRIPTION-->">
    <link rel="shortcut icon" href="favicon.ico" />
    <style>
        <?=file_get_contents($website_css);?>
    </style>
</head>
<body>
    <?if($show_title)include(getView("header"));?>
    <?include(getView("menu"));?>
        <div class="contentPage">
            <?
                if($pageLogic !== "")
                    include($pageLogic);
                if(isset($error)){
                    ?>
                    <div class="error"><?=$error?></div>
                    <?
                }
                if(isset($message)){
                    ?>
                    <div class="message"><?=$message?></div>
                    <?
                }
                if(isset($showPageContent) && $showPageContent)
                    include($pageContent);
            ?>
        </div>
    <?=$sessionManager->getLoginString()?>
    
    <?include(getView("footer"));?>

    <?
      // Set Title and Description
      if($title != "") $pageTitle = $title;
      else $pageTitle = $website_title;
      
      if($description != "") $pageDescription = $description;
      else $pageDescription = $website_description;

      $pageContents = ob_get_contents (); // Get all the page's HTML into a string
      ob_end_clean (); // Wipe the buffer

      $pageContents = str_replace ('<!--TITLE-->', $pageTitle, $pageContents);
      $pageContents = str_replace ('<!--DESCRIPTION-->', $pageDescription, $pageContents);
      
      // render page
      echo $pageContents;
    ?>

</body>
</html>
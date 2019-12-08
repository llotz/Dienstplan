<?php
    // standard Pages
    $menuLinks = array(
        array("Übersicht", "/"),
        array("Kalender", "/calendar")
    );

    // logged in Pages
    if($sessionManager->isLoggedIn())
    {
        array_push($menuLinks, array("Meine Dienste", "/mytrainings"));
    }
	$userPermissionLevel = getHighestUserPermissionLevel();
    // special permission pages
    if( $userPermissionLevel >= 50){
        array_push($menuLinks, array("Dienste planen", "/trainingadmin"));
    }

    // special permission pages
    if($userPermissionLevel >= 50){
        array_push($menuLinks, array("Neuer Dienst", "/trainingedit"));
    }

    if($userPermissionLevel >= 100){
        array_push($menuLinks, array("pwgen", "/pwgen"));
    }

    // standard pages at the end
    array_push($menuLinks, array("Über", "/about"));
?>
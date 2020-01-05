<?

    function getView($pageName){
        global $website_views;
        
        $pageName = str_replace("-", "/", $pageName);

        $path = "$website_views/$pageName.php";
        if(file_exists($path))
            return $path;
        else
            return "$website_views/404.php";
    }

    function getViewModel($pageName){
        global $website_viewmodels;
        $pageName = str_replace("-", "/", $pageName);

        $path = "$website_viewmodels/$pageName.php";
        if(file_exists($path))
            return $path;
        else 
            return "";
    }

    function getBiz($name){
        global $website_buissneslogic;
        $name = str_replace("-", "/", $name);
        $path = "$website_buissneslogic/$name.php";
        if(file_exists($path))
            return $path;
        else 
            return "";
    }

    function getHtmlLink($pageName){
        return $pageName;
    }

    function redirect($target){
        header('Location: '."/".$target);
    }

    function GetHtmlSelector($selectorName, $inputArray, $valueName, $displayName, $selectedValue = null, $addEmptySelectItem = false, $emptySelectItemName = "Alle"){
        if(!is_array($inputArray)) return "";
        $returnValue = "<select name=".$selectorName.">";
        if($addEmptySelectItem)
            $returnValue.="<option value=''>".$emptySelectItemName."</option>";
        foreach($inputArray as $item){
            if($selectedValue != null && $selectedValue == $item[$valueName]){
                $returnValue .= GethtmlSelectorSelectedItem($item[$valueName], $item[$displayName]);
            }else
                $returnValue .= GetHtmlSelectorItem($item[$valueName], $item[$displayName]);
        } 
        $returnValue .= "</select>";
        return $returnValue;
    }

    function GetHtmlSelectorItem($value, $display)
    {
        return "<option value='{$value}'>{$display}</option>";
    }

    function GetHtmlSelectorSelectedItem($value, $display)
    {
        return "<option selected value='{$value}'>{$display}</option>";
    }

    function getHighestUserPermissionLevel(){
        global $sessionManager;
        $mailAdress = $sessionManager->getMailAdress();
        if($mailAdress == "") return;

        global $db;
        $db->join("User_Department ud", "ud.UserId = u.id", "LEFT");
        $db->join("Role r", "ud.roleId = r.id", "LEFT");
        $db->join("Permission p", "p.id = r.PermissionId", "LEFT");
        $db->where("u.Mail", $mailAdress);
        $db->orderBy("p.Permissionlevel", "Desc");
        $results = $db->get("User u", null, "p.Permissionlevel");
        return $results[0]["Permissionlevel"];
    }

    function actionNoPermission(){
        ShowError("Sie haben dafür keine Berechtigung!", false);
    }

    function ShowError($errorMessage = "", $showContent = true){
        global $showPageContent;
        global $error;
        if($error == null)
            $error = (($errorMessage == "") ? "Error!" : $errorMessage);
        $showPageContent = $showContent;
    }

    function mynl2br($text) { 
        return strtr($text, array("\r\n" => '<br />', "\r" => '<br />', "\n" => '<br />')); 
    } 

    function mybr2nl($text) { 
        return strtr($text, array('<br />' => "\r\n")); 
    } 

    function requireLogin(){
        global $sessionManager;
        if(!$sessionManager->isLoggedIn())
            ShowError("Dafür musst Du eingeloggt sein!", false);
    }

    function requireAdminPermission(){
        requirePermissionLevel(100);
    }

    function requireLeaderPermission(){
        requirePermissionLevel(50);
    }

    function requirePermissionLevel($minRequiredPermissionLevel){
        global $sessionManager;
        if(!$sessionManager->isLoggedIn() || getHighestUserPermissionLevel() < $minRequiredPermissionLevel)
            ShowError("Dafür hast du keine Berechtigung!", false);
    }

    function ShowMessage($notificationMessage, $showContent = true){
        global $message;
        $message = $notificationMessage;
        $showPageContent = $showContent;
    }

    function GetDateTimeFromDateAndTimeString($date, $time){
        return new DateTime($date . ' ' . $time);
    }

    function GetDateTimeStringFromDateAndTimeString($date, $time){
        $dateTime = GetDateTimeFromDateAndTimeString($date, $time);
        return $dateTime->format('Y-m-d H:i:s');
    }

    function loadJsonAsArray($modelName){
        $rootPath = $_SERVER['DOCUMENT_ROOT'];
        $path = "$rootPath/models/$modelName.json";
        $content = file_get_contents($path);
        return json_decode($content, true);
    }
?>
<?php
session_start();

if ($_SESSION['authenticated'] != true || $_SESSION['admin'] != "false") {
    header("Location: https://jordanacartwright.com/projects/webapp/projectOverlord/");
    die();
}


require_once("functions.php");

print_html_header("Insert User");

$action = $_POST['action'];
$okToMake = true;

if ($action == "Insert User" ) {
    $usr = $_POST['username'];
    $pwd = $_POST['password'];
    $confPwd = $_POST['confpassword'];
    $usrTyp = $_POST['userType'];
    $games = $_POST['games'];
    $points = $_POST['points'];
    
    //check to make sure both passwords are the same
    if($pwd != $confPwd) {
        $errPass = "These passwords do not match";
        $okToMake = false;
    }
    if(empty($_POST['password']))
    {
        $errPass = 'Please create a password';
        $okToMake = false;
    }
    if(empty($_POST['username']))
    {
        $errUsr = 'Please insert a username';
        $okToMake = false;
    }
    if(empty($_POST['userType']))
    {
        $errType = 'Please select an account type';
        $okToMake = false;
    }
    
    if($okToMake) {
        $pwd = password_hash($pwd, PASSWORD_BCRYPT);
        $mysqli = db_connect();	

        $sql = "INSERT INTO Users8675309 (username, password, userType, games, points) VALUES ('$usr','$pwd','$usrTyp','$games','$points')";

        if ($mysqli->query($sql)) {
            $resultMsg = '<div class="alert alert-success text-center" role="alert">
                            <p>The user <strong>'.$usr.'</strong> was registered successfully!</p>
                            <p><a href="view_users.php">View Users</a></p>
                            </div>';
          //die();
        }
        elseif ($mysqli->errno == 1062) {
            $resultMsg = '<div class="alert alert-danger text-center" role="alert">
                            <p> Sorry, but <strong>'.$usr.'</strong> is an already registered user.</p>
                            </div>';
          //die();
       }
       else {
          die("Error ($mysqli->errno) $mysqli->error");
       } 

        $mysqli->close();
    }
}
?>

    
            <form method="post" name="registerform" action="insert_user.php">
                <div class="form-group">
                    <div class="offset-sm-2 col-sm-10">
                        <?
                        if($resultMsg) 
                            echo $resultMsg;
                         
                        ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="type" class="col-sm-2 col-form-label">User Type:</label>
                    <div class="col-sm-10">
                        <select class="custom-select" name="userType">
                          <option></option>
                          <option value="admin">Administrator</option>
                          <option value="normal">Standard</option>
                        </select>
                        <?php echo "<p class='text-danger'>$errType</p>";?>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="username" class="col-sm-2 col-form-label">Username:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="username" placeholder="Username" value="<? if(!$resultMsg){echo htmlspecialchars($_POST['username']);} ?>">
                        <?php echo "<p class='text-danger'>$errUsr</p>";?>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="password" class="col-sm-2 col-form-label">Password:</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" name="password" placeholder="Password" value="<? if(!$resultMsg){echo htmlspecialchars($_POST['password']);} ?>">
                        <?php echo "<p class='text-danger'>$errPass</p>";?>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="confpassword" class="col-sm-2 col-form-label">Confirm Password:</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" name="confpassword" placeholder="Confirm Password" value="<? if(!$resultMsg){echo htmlspecialchars($_POST['confpassword']);} ?>">
                        <?php echo "<p class='text-danger'>$errPass</p>";?>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="username" class="col-sm-2 col-form-label">Games Played:</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" name="games" value="0">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="username" class="col-sm-2 col-form-label">Points Scored:</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" name="points" value="0">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="offset-sm-2 col-sm-10">
                        <input type="submit" name="action" value="Insert User" class="btn btn-primary btn-block">
                    </div>
                </div>
            </form>
 <? print_html_footer(); ?>
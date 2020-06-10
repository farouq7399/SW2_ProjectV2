<?php
include('./classes/DB.php');
include('./classes/Login.php');

$username = "";
$verified = False;
$isFollowing = False;
if (isset($_GET['username'])) {
        if (DB::query('SELECT username FROM users WHERE username=:username', array(':username'=>$_GET['username']))) {

                $username = DB::query('SELECT username FROM users WHERE username=:username', array(':username'=>$_GET['username']))[0]['username'];
                $userid = DB::query('SELECT id FROM users WHERE username=:username', array(':username'=>$_GET['username']))[0]['id'];
                $verified = DB::query('SELECT verified FROM users WHERE username=:username', array(':username'=>$_GET['username']))[0]['verified'];
                $followerid = Login::isLoggedIn();


                //check if user is following the other user
                if (isset($_POST['follow'])) {

                        if ($userid != $followerid) {

                                if (!DB::query('SELECT follower_id FROM followers WHERE user_id=:userid AND follower_id=:followerid', array(':userid'=>$userid, ':followerid'=>$followerid))) {
                                        if ($followerid == 6) {
                                                DB::query('UPDATE users SET verified=1 WHERE id=:userid', array(':userid'=>$userid));
                                        }
                                        DB::query('INSERT INTO followers VALUES (\'\', :userid, :followerid)', array(':userid'=>$userid, ':followerid'=>$followerid));
                                } else {
                                        echo 'Already following!';
                                }
                                $isFollowing = True;
                        }
                }
                if (isset($_POST['unfollow'])) {

                        if ($userid != $followerid) {

                                if (DB::query('SELECT follower_id FROM followers WHERE user_id=:userid AND follower_id=:followerid', array(':userid'=>$userid, ':followerid'=>$followerid))) {
                                        if ($followerid == 6) {
                                                DB::query('UPDATE users SET verified=0 WHERE id=:userid', array(':userid'=>$userid));
                                        }
                                        DB::query('DELETE FROM followers WHERE user_id=:userid AND follower_id=:followerid', array(':userid'=>$userid, ':followerid'=>$followerid));
                                }
                                $isFollowing = False;
                        }
                }
                if (DB::query('SELECT follower_id FROM followers WHERE user_id=:userid AND follower_id=:followerid', array(':userid'=>$userid, ':followerid'=>$followerid))) {
                        //echo 'Already following!';
                        $isFollowing = True;
                }

                //posting body
                if (isset($_POST['post'])) {
                        $postbody = $_POST['postbody'];
                        $postbody = $_POST['postbody'];
                        $loggedInUserId = Login::isLoggedIn();

                        if (strlen($postbody) > 160 || strlen($postbody) < 1) {
                                die('Incorrect length!');
                        }

                        if ($loggedInUserId == $userid) {

                                DB::query('INSERT INTO posts VALUES (\'\', :postbody, NOW(), :userid, 0)', array(':postbody'=>$postbody, ':userid'=>$userid));
                        } else {
                                die('Incorrect user!');
                        }
                }

                if (isset($_GET['postid'])) {
                        if (!DB::query('SELECT user_id FROM post_likes WHERE post_id=:postid AND user_id=:userid', array(':postid'=>$_GET['postid'], ':userid'=>$followerid))) {
                                DB::query('UPDATE posts SET likes=likes+1 WHERE id=:postid', array(':postid'=>$_GET['postid']));
                                DB::query('INSERT INTO post_likes VALUES (\'\', :postid, :userid)', array(':postid'=>$_GET['postid'], ':userid'=>$followerid));
                        } else {
                                DB::query('UPDATE posts SET likes=likes-1 WHERE id=:postid', array(':postid'=>$_GET['postid']));
                                DB::query('DELETE FROM post_likes WHERE post_id=:postid AND user_id=:userid', array(':postid'=>$_GET['postid'], ':userid'=>$followerid));
                        }
                }

                $dbposts = DB::query('SELECT * FROM posts WHERE user_id=:userid ORDER BY id DESC', array(':userid'=>$userid));
                $posts = "";
                //print privous posts
                foreach($dbposts as $p) {

                if(!DB::query('SELECT post_id FROM post_likes WHERE post_id=:postid AND user_id=:userid', array(':postid'=>$p['id'],':userid'=>$followerid))){

                        $posts .= htmlspecialchars($p['body'])."
                        <form action='profile.php?username=$username&postid=".$p['id']."' method='post'>
                                <input type='submit' name='like' value='Like'>
                                <span>".$p['likes']."</span>
                        </form>
                        <hr /></br />
                        ";
                      }  else {
                        $posts .= htmlspecialchars($p['body'])."
                        <form action='profile.php?username=$username&postid=".$p['id']."' method='post'>
                                <input type='submit' name='unlike' value='Unlike'>
                                <span>".$p['likes']."</span>
                        </form>
                        <hr /></br />
                        ";
                      }
                }


        } else {
                die('User not found!');
        }
}


?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="css/profile.css">
    <title>Profile</title>
  </head>
  <body>
    <div id="emad-app">
      <div class="page-content">
        <header>
          <h1 class="name"><?php echo $username; ?>'s Profile<?php if ($verified) { echo ' - Verified'; } ?></h1>
          <div class="logout">Logout<i class="fas fa-sign-out-alt"></i></div>
        </header>
        <div class="containers">
          <div class="about">
            <h2>About Me</h2>
            <p>Welocme to my profile.</p>
          </div>
          <div class="right">
            <div class="new-post">
              <button class="add-post" v-on:click="addForm">NEW POST</button>
            </div>
            <div class="post">
              <new-post v-for="(n, index) in range" :key="index" :title="title" :content="content" :author="author"></new-post>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script src="js/vue.js"></script>
    <script src="js/website.js"></script>
    <script src="https://kit.fontawesome.com/5c514b09fd.js" crossorigin="anonymous"></script>
  </body>
</html>

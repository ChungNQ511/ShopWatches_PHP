<?php include 'inc/header.php'; ?>
<?php
$login_check = Session::get('customer_login');
if ($login_check) {
    // $userId = Session::get('customer_id');
    $userName = Session::get('customer_name');
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['Send'])) {
        $insert_mess = $cs->insert_mess($userName);
    }
} else {
    echo "<script>window.location ='index.php'</script>";
}
?>
<div class=main>
    <div class="container">
        <div class="row mt-5">
            <form action="" method="post">
                <div class="col-md-6 offset-md-3 col-sm-6 offset-sm-3 col-12 comments-main pt-4 rounded">
                    <?php
                    $show_mess = $cs->show_mess_forid($userName);
                    if ($show_mess) {
                        while ($result = $show_mess->fetch_assoc()) {
                    ?>
                            <ul class="p-0">
                                <li>
                                    <div class="row comments mb-2">
                                        <div class="col-md-2 col-sm-2 col-3 text-center user-img">
                                            <img id="profile-photo" src="http://nicesnippets.com/demo/man01.png" class="rounded-circle" />
                                        </div>
                                        <div class="col-md-9 col-sm-9 col-9 comment rounded mb-2">
                                            <h4 class="m-0"><?php echo $result['userName'] ?></h4>
                                            <time class="text-white ml-3"><?php echo $result['NgaySend'] ?></time>
                                            <like></like>
                                            <p class="mb-0 text-white" name="message"><?php echo $result['MessUser'] ?>
                                            </p>
                                            <?php
                                            if ($result['reply_admin'] != '' || $result['reply_admin'] != null) { ?>
                                                <!-- admin -->
                                                <div class="row comments mb-2">
                                                    <div class="col-md-2 col-sm-2 col-3 text-center user-img">
                                                        <img id="profile-photo" src="http://nicesnippets.com/demo/man02.png" class="rounded-circle" />
                                                    </div>
                                                    <div>
                                                        <h4 class="m-0">Admin</h4>
                                                        <time class="text-white ml-3"><?php echo $result['NgayRep'] ?></time>
                                                        <like></like>
                                                        <p class="mb-0 text-red" name="message"><?php echo $result['reply_admin'] ?>
                                                        </p>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                </li>
                        <?php }
                    } ?>
                        <div class="row comment-box-main p-3 rounded-bottom">
                            <div class="col-md-9 col-sm-9 col-9 pr-0 comment-box">
                                <input type="text" class="form-control" name="messsend" placeholder="comment ...." />
                            </div>
                            <div class="col-md-3 col-sm-2 col-2 pl-0 text-center send-btn">
                                <button class="btn btn-info" name="Send">Send</button>
                            </div>
                        </div>
                        <?php
                        if (isset($insert_mess)) {
                            echo $insert_mess;
                        }
                        ?>
                </div>
            </form>
        </div>
    </div>
    <?php
    include 'inc/footer.php';

    ?>
<?php include 'inc/header.php'; ?>
<?php

$filepath = realpath(dirname(__FILE__));
include_once($filepath . '/../classes/customer.php');
include_once($filepath . '/../helpers/format.php');
?>
<?php

if (!isset($_GET['reply']) || $_GET['reply'] == NULL) {
    echo "<script>window.location ='show_chat.php'</script>";
} else {
    $chatId = $_GET['reply'];
}
$cs = new customer();

$userName = $cs->get_userName_by_chatId($chatId);
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['reply'])) {
    $admin_reply = $cs->admin_reply($chatId);
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
                                    <img id="profile-photo" src="http://nicesnippets.com/demo/man01.png"
                                        class="rounded-circle" />
                                </div>
                                <div class="col-md-9 col-sm-9 col-9 comment rounded mb-2">
                                    <h4 class="m-0"><?php echo $result['userName'] ?></h4>
                                    <!-- <time class="text-white ml-3"><?php echo $result['NgaySend'] ?></time> -->
                                    <like></like>
                                    <p class="mb-0 text-white" name="message"><?php echo $result['MessUser'] ?>
                                    </p>
                                </div>
                            </div>
                        </li>
                        <?php }
                    } ?>
                        <div class="row comment-box-main p-3 rounded-bottom">
                            <div class="col-md-9 col-sm-9 col-9 pr-0 comment-box">
                                <input type="text" class="form-control" name="messadmin" placeholder="Reply ...." />
                            </div>
                            <div class="col-md-3 col-sm-2 col-2 pl-0 text-center send-btn">
                                <button class="btn btn-info" name="reply">Reply</button>
                            </div>
                        </div>
                </div>
            </form>
        </div>
    </div>
    <?php
    include 'inc/footer.php';

    ?>
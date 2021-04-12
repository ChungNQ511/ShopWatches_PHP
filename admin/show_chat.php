<?php include 'inc/header.php'; ?>
<?php include 'inc/sidebar.php'; ?>
<?php include '../classes/brand.php'; ?>
<?php include '../classes/category.php'; ?>
<?php include '../classes/product.php'; ?>
<?php include '../classes/customer.php'; ?>
<?php include_once '../helpers/format.php'; ?>
<?php
$cs = new customer();
$fm = new Format();
if (isset($_GET['chatId'])) {
    $id = $_GET['chatId'];
    $reply = $cs->Admin_reply($id);
}
?>
<div class="grid_10">
    <div class="box round first grid">
        <h2>Comment</h2>
        <div class="block">
            <!-- <?php
                    if (isset($delcomment)) {
                        echo $delcomment;
                    }
                    ?> -->
            <table class="data display datatable" id="example">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>From</th>
                        <th>Description</th>
                        <th>Date Time</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $chatlist = $cs->show_chat();
                    if ($chatlist) {
                        $i = 0;
                        while ($result = $chatlist->fetch_assoc()) {
                            $i++;
                    ?>
                    <tr class="odd gradeX">
                        <td><?php echo $i ?></td>
                        <td><?php echo $result['userName'] ?></td>
                        <td><?php echo $result['MessUser'] ?></td>
                        <td><?php echo $result['NgaySend'] ?></td>
                        <td><a href="adminchat.php?reply=<?php echo $result['chatId'] ?>">
                                <?php
                                        if ($result['reply_admin'] != '' || $result['reply_admin'] != null)
                                            echo "Reponsed";
                                        else echo "Reply"; ?></a></td>
                    </tr>
                    <?php
                        }
                    }
                    ?>
                </tbody>
            </table>

        </div>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function() {
    setupLeftMenu();
    $('.datatable').dataTable();
    setSidebarHeight();
});
</script>
<?php include 'inc/footer.php'; ?>
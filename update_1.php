<?php
session_start();
require_once 'database_1.php';
if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
    $_SESSION['error']='ID không hợp lệ';
    header('Location:index_1.php');
    exit();
}
$id=$_GET['id'];
    $sql_select = "SELECT * FROM categories WHERE id=$id";
    $result = mysqli_query($connection, $sql_select);
    $category = [];
    if (mysqli_num_rows($result) > 0) {
        $category_arr =mysqli_fetch_all($result,MYSQLI_ASSOC);
        $category = $category_arr[0];
    }
echo "<pre>";
print_r($category_arr);
echo "</pre>";
if(isset($_POST['submit'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $avatar_arr = $_FILES['avatar'];
    $avatar = '';
    if ($avatar_arr['error'] == 0) {
        $dir_upload = __DIR__ . '/upload_1';
        $avatar = time() . '-' . $avatar_arr['name'];
        move_uploaded_file($avatar_arr['tmp_name'], $dir_upload . '/' . $avatar);
    }
    $sql_update = "UPDATE categories SET 
     `name`='$name', `description`='$description',`avatar`='$avatar' WHERE id={$category['id']}";
    $is_update = mysqli_query($connection, $sql_update);
    if ($is_update) {
        $_SESSION['success'] = 'Update thành công';
        header('Location:index_1.php');
    } else {
    $_SESSION['error'] = 'Update thất bại';
    }
}
?>
<form action="" method="post" enctype="multipart/form-data">
    <h5>
        Cập nhật danh mục với id = <?php echo $category['id']; ?>
    </h5>
    Name:
    <input type="text" name="name" value="<?php echo $category['name']; ?>"/>
    <br />
    Description:
    <textarea name="description" cols="20"></textarea>
    <br />
    Upload avatar:
    <input type="file" name="avatar"/>
    <br />
    <input type="submit" name="submit" value="Update" />
</form>

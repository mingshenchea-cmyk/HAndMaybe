<?php
require '../../../_base.php';
//-----------------------------------------------------------------------------

$_category = getAllCategory();

//-----------------------------------------------------------------------------
// Include the header
include '../../../_head.php';
?>

<link rel="stylesheet" href="/css/category.css">

<div class="container">
    <div class="category_div">
        <table class="category_table">
            <tr>
                <th>Category ID</th>
                <th>Category</th>
            </tr>
            <?php if (!is_post()): ?>
                <?php foreach ($_category as $categorys): ?>
                    <tr>
                        <td>
                            <p class="data"><?= $categorys->category_id ?></p>
                        </td>
                        <td>
                            <p class="data"><?= $categorys->category ?></p>
                        </td>
                    </tr>
                <?php endforeach ?>
            </table>
            <div class="edit_box">
                <form action="" method="POST">
                    <input type="hidden" name="action" value="add">
                    <button class="category_add">
                        <img class='button_icon' src='/images/add_white.png'>
                        <p class="add">Add</p>
                    </button>
                </form>
                <form action="" method="POST">
                    <input type="hidden" name="action" value="edit">
                    <button class="edit_button">
                        <img class='button_icon' src='/images/edit.png'>
                        <p class="add">Edit</p>
                    </button>
                </form>
            </div>
        <?php elseif (is_post() && isset($_POST['action']) && post('action') == 'add'): ?>
            <?php foreach ($_category as $categorys): ?>
                <tr>
                    <td>
                        <p class="data"><?= $categorys->category_id ?></p>
                    </td>
                    <td>
                        <p class="data"><?= $categorys->category ?></p>
                    </td>
                </tr>
            <?php endforeach ?>
            <form action="" method="POST">
                <input type="hidden" name="action" value="save_add">
                <tr>
                    <td>
                        <p class="data"><?= $categorys->category_id + 1 ?></p>
                    </td>
                    <td>
                        <input type='text' name='new_category' value=''>
                        <?= err('new_category') ?>
                    </td>
                </tr>
                </table>
                <div class="edit_box">
                    <button class="save_button">
                        <img class='button_icon' src='/images/save.png'>
                        <p class="add">Save</p>
                    </button>
                </div>
            </form>
        <?php elseif (is_post() && isset($_POST['action']) && post('action') == 'save_add'): ?>
            <?php $new_category = post('new_category'); ?>

            <?php
            $new_category = ucfirst(strtolower(trim($new_category)));

            $check_stmt = $_db->prepare("SELECT COUNT(*) FROM category WHERE category = ?");
            $check_stmt->execute([$new_category]);
            $count = $check_stmt->fetchColumn(); ?>

            <?php if (!$_err): ?>
                <?php if ($count == 0): ?>
                    <?php
                    temp('info','Category Added Successfully!');
                    addCategory($new_category);
                    redirect("/page/admin/category/category_maintenance.php");
                    ?>
                <?php endif ?>
            <?php endif ?>
        <?php elseif (is_post() && isset($_POST['action']) && post('action') == 'edit'): ?>
            <?php foreach ($_category as $categorys): ?>
                <tr>
                    <td>
                        <p class="data"><?= $categorys->category_id ?></p>
                        <input type="hidden" name="category_id" value="<?= $categorys->category_id ?>">
                    </td>
                    <form action="" method="POST">
                        <input type="hidden" name="action" value="save_edit">
                        <td>
                            <input type='text' name='edit_category' value='<?= $categorys->category ?>'>
                        </td>
                        <td class="delete_box">
                            <input type="hidden" name="edit_category_id" value="<?= $categorys->category_id ?>">
                            <button class="save_button">
                                <img class='button_icon' src='/images/save.png'>
                                <p class="add">Save</p>
                            </button>
                    </form>
                    <form action="" method="POST">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="category_id" value="<?= $categorys->category_id ?>">
                        <button class="delete_button">
                            <img class='button_icon' src='/images/delete.png'>
                            <p class="add">Delete</p>
                        </button>
                    </form>
                    </td>
                </tr>
            <?php endforeach ?>
            </table>
        <?php elseif (is_post() && post('action') === 'delete'): ?>
            <?php
            $category_id = post('category_id');

            if ($category_id) {
                temp('info','Category Deleted Successfully!');
                deleteCategory($category_id);
            }

            redirect("/page/admin/category/category_maintenance.php");
            ?>
        <?php elseif (is_post() && isset($_POST['action']) && post('action') == 'save_edit'): ?>
            <?php $edit_category_id = post('edit_category_id');
            $edit_category = post('edit_category');

            $edit_category = ucfirst(strtolower(trim($edit_category)));

            if ($edit_category) {
                temp('info','Category Updated Successfully!');
                updateCategory($edit_category, $edit_category_id);
            }

            redirect("/page/admin/category/category_maintenance.php"); ?>
        <?php endif ?>
    </div>
</div>


<?php
// Include the footer
include '../../../_foot.php';
?>
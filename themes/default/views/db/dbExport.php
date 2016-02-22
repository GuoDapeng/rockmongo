<script type="text/javascript">
    function checkAll(obj) {
        $(".check_collection").attr("checked", obj.checked);
    }
</script>

<h3><?php render_navigation($db); ?> &raquo; <?php hm("export"); ?></h3>


<form method="post">
    <input type="hidden" name="can_download" value="0"/>

    <?php hm("collections"); ?>
    [<label><?php hm("all"); ?> <input type="checkbox" name="check_all" value="1" onclick="checkAll(this)"/></label>]
    <ul class="list">
        <?php if (empty($collections)): ?>
            <?php hm("nocollections"); ?>
        <?php else: ?>
            <?php foreach ($collections as $collection): ?>
                <li>
                    <label>
                        <input type="checkbox"
                               class="check_collection"
                               name="checked[<?php h($collection->getName()); ?>]"
                               value="1"
                            <?php if (in_array($collection->getName(), $selectedCollections)): ?>
                                checked="checked"<?php endif; ?>
                        />
                        <?php h($collection->getName()); ?>
                    </label>
                </li>
            <?php endforeach; ?>
        <?php endif; ?>
    </ul>
    <div class="clear"></div>
    <br/>
    <?php hm("download"); ?><br/>
    <input type="checkbox" name="can_download" value="1"
        <?php if (x("can_download")): ?>
            checked="checked"
        <?php endif; ?>
    />
    <br/>
    <?php hm("compressed"); ?>:<br/>
    <label><input type="checkbox" name="gzip" value="1"/> GZIP</label>
    <br/>
    <?php hm("butts"); ?>:<br/>
    <label><input type="checkbox" name="butts" value="1"/> Backup</label>
    <br/>
    <br/>
    <input type="submit" value="<?php hm("export"); ?>"/>
</form>

<?php if (!x("can_download") && isset($contents)): ?>
    <?php if (x("butts")): ?>

    <?php else: ?>
        <?php h($countRows); ?>
        <?php hm("rowsexported"); ?>:<br/>
        <textarea rows="30" cols="70">
            <?php h($contents); ?>
        </textarea>
    <?php endif; ?>
<?php endif; ?>

<br/>
<br/>
<?php
//获取某目录下所有文件、目录名（不包括子目录下文件、目录名）
$handler = opendir(BACKUP_DIR);
while (($filename = readdir($handler)) !== false) {//务必使用!==，防止目录下出现类似文件名“0”等情况
    if ($filename != "." && $filename != "..") {
        $files[] = $filename;
    }
}

closedir($handler);

//打印所有文件名
//foreach ($files as $value) {
//    echo $value . "<br />";
//}
?>
<p><?php hm("Backed_list"); ?></p>

<?php
/**
 * 方便的显示文件大小
 *
 * @param $filesize
 *
 * @return string
 */
function sizecount($filesize)
{
    if ($filesize >= 1073741824) {
        $filesize = round($filesize / 1073741824 * 100) / 100 . ' gb';
    } elseif ($filesize >= 1048576) {
        $filesize = round($filesize / 1048576 * 100) / 100 . ' mb';
    } elseif ($filesize >= 1024) {
        $filesize = round($filesize / 1024 * 100) / 100 . ' kb';
    }

    return $filesize;
}

?>

<form method="post">
    <input type="hidden" name="format" value="delete"/>
    <table>
        <tr>
            <td></td>
            <td><?php hm("name"); ?></td>
            <td><?php hm("size"); ?></td>
            <td><?php hm("download_url"); ?></td>
        </tr>
        <?php foreach ($files as $value): ?>
            <tr>
                <td>
                    <label><input name="name" type="radio" value="<?php echo $value ?>" /></label>
                </td>
                <td>
                    <?php echo $value ?>
                </td>
                <td>
                    <?php echo sizecount(filesize(BACKUP_DIR . '/' . $value)); ?>
                </td>
                <td>
                    <a href="<?php echo SERVER_PATH . BACKUP_DIR . '/' . $value ?>"><?php hm("download_url"); ?></a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <input type="submit" value="<?php hm("delete"); ?>"/>
</form>
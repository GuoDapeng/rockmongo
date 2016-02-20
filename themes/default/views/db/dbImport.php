<h3><?php render_navigation($db); ?> &raquo; <?php hm("import"); ?></h3>

<?php if (isset($error)): ?> <p class="error"><?php h($error); ?></p><?php endif; ?>
<?php if (isset($message)): ?>
    <p class="message"><?php h($message); ?></p>
    <script language="javascript">
        window.parent.frames["left"].location.reload();
    </script>
<?php endif; ?>

<p><strong>.js</strong> file exported with RockMongo:</p>

<form method="post" enctype="multipart/form-data">
    <input type="hidden" name="format" value="js"/>
    JS File: <input type="file" style="width:400px" name="json"/><br/>
    <input type="submit" value="<?php hm("import"); ?>"/>
</form>

<hr style="margin:20px 0px"/>
<?php if (isset($error2)): ?> <p class="error"><?php h($error2); ?></p><?php endif; ?>
<?php if (isset($message2)): ?>
    <p class="message"><?php h($message2); ?></p>
    <script language="javascript">
        window.parent.frames["left"].location.reload();
    </script>
<?php endif; ?>
<p><strong>.json</strong> file exported with <a href="http://www.mongodb.org/display/DOCS/Import+Export+Tools"
                                                target="_blank">mongoexport</a>:</p>

<form method="post" enctype="multipart/form-data">
    <input type="hidden" name="format" value="json"/>
    Import to collection name:<input type="text" name="collection"/><br/>
    JSON File: <input type="file" style="width:400px" name="json"/><br/>
    <input type="submit" value="<?php hm("import"); ?>"/>
</form>

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
    <input type="hidden" name="format" value="local"/>
    <table>
        <tr>
            <td></td>
            <td><?php hm("name"); ?></td>
            <td><?php hm("size"); ?></td>
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
            </tr>
        <?php endforeach; ?>
    </table>
    <input type="submit" value="<?php hm("import"); ?>"/>
</form>

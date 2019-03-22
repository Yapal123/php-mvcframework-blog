
<div class="content-wrapper">
    <div class="container-fluid">
        <div class="card mb-3">
            <div class="card-header"><?php $title;  ?></div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-4">
                    	Hello, <?php echo $_SESSION['username']; ?>
                    	<?php if (file_exists($_SERVER['DOCUMENT_ROOT'].'/public/materials/ava/'.$_SESSION['username'].'.jpg')):?>

                    		<img src="<?php $_SERVER['DOCUMENT_ROOT']?>/public/materials/ava/<?php echo $_SESSION['username']?>.jpg">                  	
                            <?php else: ?>
                    		<img src="<?php $_SERVER['DOCUMENT_ROOT']?>/public/materials/ava.jpg">

                        <?php endif ?>
                       
                        <form action="<?php $_SERVER['DOCUMENT_ROOT'] ?>/admin/ava" method="post" enctype="multipart/form-data" >
                            <div class="form-group">
                                <label>Изображение</label>
                                <input class="form-control" type="file" name="ava">
                            </div>
                            <input type="submit" class="btn btn-primary btn-block" value="Сохранить" name="send"></input>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
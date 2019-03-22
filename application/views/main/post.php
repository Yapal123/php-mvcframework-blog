
<header class="masthead" style="background-image: url('/public/materials/<?php echo $data['id']; ?>.jpg')">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-10 mx-auto">
                <div class="page-heading">
                    <h1><?php echo htmlspecialchars($data['title'], ENT_QUOTES); ?></h1>
                    <span class="subheading"><?php echo htmlspecialchars($data['description'], ENT_QUOTES); ?></span>
                </div>
            </div>
        </div>
    </div>
</header>
<div class="container">
    <div class="row">
        <div class="col-12">
            <p><?php echo $data['text'] ?></p>
        </div>
    </div>
</div>
    <div class="page-heading">
       <strong> Комментарии </strong>    
    </div>
 <div class="container">  
<?php if (empty($comments)):?>
 <div class="page-heading">Пока никто не прокоментрировал это</div>
<?php endif ?>
<?php foreach ($comments as $comment):?>
    <br>
<div class="row">
    <div class="media " style="float: none;">
    <?php $ava = $comment['name']; ?>
    <?php if (file_exists($_SERVER['DOCUMENT_ROOT'].'/public/materials/ava/'.$ava.'.jpg')):?>

                            <img src="<?php $_SERVER['DOCUMENT_ROOT']?>/public/materials/ava/<?php echo $ava?>.jpg">                   
                            <?php else: ?>
                            <img src="<?php $_SERVER['DOCUMENT_ROOT']?>/public/materials/ava.jpg">

                        <?php endif ?>

  <div class="media-body">
    <h5 class="mt-0"><?php echo $comment['name'] ?></h5>
    <?php echo $comment['text'] ?>
    </div>

  </div>
</div> 

<div class="w-100"></div>
<br>
<?php endforeach ?>
    </div>
     <div class="page-heading">
     <strong>Оставьте свой комментарий </strong>    
 </div>
 <?php if (isset($_SESSION['authorize'])):?>

<div class="container">
  <form action="<?php $_SERVER['DOCUMENT_ROOT'] ?>/main/comment" method="post" class="form">
                            <div class="form-group">
                            
                                <input class="form-control" type="hidden" name="name" value="<?php echo $_SESSION['username'] ?>" >
                                <input class="form-control" type="hidden" name="postId" value="<?php echo $this->route['id']?>" >
                            </div>
                         
                            <div class="form-group">
                                <label>Текст</label>
                                <textarea class="form-control" rows="5" name="text"></textarea>
                            </div>
                          
                            <button type="submit" class="btn btn-primary btn-block">Добавить</button>
                        </form>
</div>
<?php else: ?>
    <div class="page-heading">
        Комментарии могут оставлять только авторизированные пользователи.
    </div>
<?php endif ?>
</div>

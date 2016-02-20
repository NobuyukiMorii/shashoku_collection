<div class="boxList">
    <?php
    // echo "<pre>";
    // var_dump($response);
    // echo "</pre>";
    if(!empty($response['logs'])){
        $histories = $response['logs'];
    }
    ?>

<h2>12月</h2>

    <?php
    if (isset($histories) && count($histories) > 0) {
        foreach ($histories as $history) {
            $history["id"] = "1";
    ?>
            <p class="pdlr-10"><?php echo $history['log']['created'] ?></p> 
            <a class="a" href="<?php echo $this->Html->url(array("controller" => "Restaurants", "action" => "detail", '?' => array('restaurant_id' => $history['id']))); ?>"><div class="img ratioFixed history" style="background-image:url('<?php echo $history['restaurant']['photos']; ?>')">
                <div class="titleBox">
                    <h4><?php echo $history['restaurant']['name']; ?></h4>
                    <p class="menu"><?php echo $history['coupon']['price']; ?>円:<?php echo $history['set_menu']['name']; ?></p>
                </div>
            </div></a>
    <?php
        }
    }
    ?>
</div>
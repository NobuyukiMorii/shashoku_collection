<div class="boxList">
    <?php
    // echo "<pre>";
    // var_dump($response);
    // echo "</pre>";
    if(!empty($response['logs'])){
        $all_histories = $response['logs'];
    }
    ?>

    <?php
    if (isset($all_histories) && count($all_histories) > 0) {
        foreach ($all_histories as $month => $histories) {
            echo "<h2>".$month."月</h2>";
            foreach ($histories as $history) {
    ?>
                <p class="pdlr-10"><?php echo $history['log']['created'] ?></p> 
                <a class="a" href="<?php echo $this->Html->url(array("controller" => "Restaurants", "action" => "detail", '?' => array('restaurant_id' => $history['restaurant']['id']))); ?>"><div class="img ratioFixed history" style="background-image:url('<?php echo $history['restaurant']['photos']; ?>')">
                    <div class="titleBox">
                        <h4><?php echo $history['restaurant']['name']; ?></h4>
                        <p class="menu"><?php echo $history['coupon']['price']; ?>円:<?php echo $history['set_menu']['name']; ?></p>
                    </div>
                </div></a>
    <?php
            }
        }
    }
    ?>
</div>
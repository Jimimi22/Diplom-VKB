<?php for ($i = 0, $count = count($this->items); $i < $count; $i++) { ?>
<li>
<strong style="<?
    if ($this->items[$i]['colored']) {
        echo 'color: #2C881B;';
    } ?>"><?php echo $this->items[$i]['user']; ?></strong>[<?php echo $this->items[$i]['date']; ?>]:<br /> 
<?php echo $this->items[$i]['message']; ?></li>
<?php } ?>
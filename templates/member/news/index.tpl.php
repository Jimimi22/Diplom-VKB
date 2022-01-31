<?php if (($count = count($this->items))) { ?>
<?php for ($i = 0; $i < $count; $i++) {?>
<div style="padding-bottom: 30px">
	<b><span style="color:#504e46;">
    <?php echo $this->items[$i]['caption']?></span></b><br />
	<p>
		<?php echo $this->items[$i]['body']?>
	</p>
	<br /><?php echo $this->items[$i]['posted']; ?>
</div>
<?php } // endfor?>
<?php $this->call('pager', 
        $this->count, 
		$this->onpage, 
		$this->page,
		$this->neighbours, '?cmd='.$this->_CMD);?>
<?php } else { ?>
There are no news
<?php } // endif?>
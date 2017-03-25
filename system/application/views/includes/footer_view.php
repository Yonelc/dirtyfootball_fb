<div id="footer">
    <div id="footer_links">
    <?php
        $level=$this->session->userdata("level");
        $email=$this->session->userdata("email");
        if(!empty($level)){ ?>

    <?php echo anchor('game/bug_tracker', $this->lang->line('footer_bug')); ?> |
    <?php echo anchor('game/cgu', $this->lang->line('footer_cgu')); ?> |
    <?php echo anchor('game/faq', $this->lang->line('footer_faq')); ?> 
    <?php if($email=="lionel.clamens@gmail.com"){ ?>
    | <?php echo anchor('backend', 'BO'); ?>
    <?php }
    }?>
    </div>

</div>
<!-- maudau code begin -->
<div style="width:758px;margin:0 auto 0 auto;">
<iframe id="maudauIframe" scrolling="no" height="72" frameborder="0" width="758" marginheight="0" marginwidth="0" src="http://www.maudau.com/AdsBar/?appid=225"></iframe>
<!-- maudau code end -->
</div>


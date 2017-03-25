<div id="main_menu" >
    <div id="welcome_message"><?=$this->lang->line('welcome_message')?></div>
    <ul>
        <li><?php echo anchor('game/index', '<img src="'.base_url().'images/'.$this->session->userdata("langage").'/global/team.png" border="none" class="tooltip" title="'.$this->lang->line('menu_manager').'" alt="team" />'); ?></li>
        <li><?php echo anchor('team/composition', '<img src="'.base_url().'images/'.$this->session->userdata("langage").'/global/tactic.png" border="none" class="tooltip" title="'.$this->lang->line('menu_team').'" alt="tactique" />'); ?></li>
        <li><?php echo anchor('match/', '<img src="'.base_url().'images/'.$this->session->userdata("langage").'/global/match.png" border="none" class="tooltip" title="'.$this->lang->line('menu_match').'" alt="match" />'); ?></li>
        <li><?php echo anchor('friendly/', '<img src="'.base_url().'images/'.$this->session->userdata("langage").'/global/amical.png" border="none" class="tooltip" title="'.$this->lang->line('menu_amical').'" alt="Friendly match" />'); ?></li>
        <li><?php echo anchor('research/', '<img src="'.base_url().'images/'.$this->session->userdata("langage").'/global/search.png" border="none" class="tooltip" title="'.$this->lang->line('menu_research').'" alt="Research" />'); ?></li>
        <li><?php echo anchor('transferts/', '<img src="'.base_url().'images/'.$this->session->userdata("langage").'/global/transfert.png" border="none" class="tooltip" title="'.$this->lang->line('menu_transfert').'" />'); ?></li>
        <li><?php echo anchor('corruption/', '<img src="'.base_url().'images/'.$this->session->userdata("langage").'/global/corruption.png" border="none" class="tooltip" title="'.$this->lang->line('menu_corruption').'" alt="corruption" />'); ?></li>
        <li><?php echo anchor('building/', '<img src="'.base_url().'images/'.$this->session->userdata("langage").'/global/construction.png" border="none" class="tooltip" title="'.$this->lang->line('menu_construction').'" alt="Constructions" />'); ?></li>
        <li><?php echo anchor('friends/', '<img src="'.base_url().'images/'.$this->session->userdata("langage").'/global/friends.png" border="none" class="tooltip" title="'.$this->lang->line('menu_amis').'" alt="friends" />'); ?></li>
        <li><?php echo anchor('payment/', '<img src="'.base_url().'images/'.$this->session->userdata("langage").'/global/money.png" border="none" class="tooltip" title="'.$this->lang->line('menu_dirtygold').'" />'); ?></li>
    </ul>
</div>

<div id="sponsor_display">
<?php
if(isset($sponsorTeam)&& !empty($sponsorTeam)){
    echo $this->lang->line("support_us");
    echo sponsors_rules::getSponsors($sponsorTeam[0]["link"]);
 }
?>
<!-- Begin Ad Call Tag - Do not Modify -->
<!--<iframe width='468' height='60' frameborder='no' framespacing='0' scrolling='no'  src='http://ads.lfstmedia.com/fbslot/slot15846?ad_size=468x60&adkey=ea8'></iframe>-->
<!-- End of Ad Call Tag -->
</div>



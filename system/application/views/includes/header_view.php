<div id="header">
    <div id="date"><div id="day"></div><div id="day_text"><?=date('Y-m-d')?></div><div id="clock"></div><div id="clock_text"><?=date('H:i:s')?></div></div>
    <div id='money'><?php echo $my_infos[0]["money"]; ?></div>
    <div id='dirty_gold'><?php echo $my_infos[0]["dirtyGold"]; ?></div>
    <div id='team_name'><?php echo substr($this->session->userdata('teamName'), 0, 15); echo " ".$this->lang->line('header_level').$this->session->userdata('level'); ?></div>
</div>

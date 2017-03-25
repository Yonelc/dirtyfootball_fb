<?php
//Sous menu
$lang['submenu_infos'] ="Informations";
$lang['submenu_complexe'] ="Sport resort";
$lang['submenu_palmares'] ="Honours list";
$lang['submenu_pantheon'] ="Pantheon";
$lang['submenu_options'] ="Options";
$lang['submenu_faq'] ="Faq";

//Progress bar
$lang['progress_champ'] ="Join a championship";
$lang['progress_compose'] ="Make your team";
$lang['progress_valide'] ="Exhibition matchs";

//Palmares tab
$lang['palmarestab_nom'] ="Championship name";
$lang['palmarestab_position'] ="Final position";
$lang['palmarestab_niveau'] ="Level";
$lang['palmarestab_date'] ="Date";

//Top
$lang['top_amis'] ="Top Friends";
$lang['top_mondial'] ="Top World";
$lang['top_level'] ="lvl ";

//Messages controller
$lang['match_program'] ="Matchs will be scheduled when championship will be completed by ten teams. <b>".anchor('friends/index','Invite your friends')."</b>!!!";
$lang['next_match'] ="Next championship match on %data1 versus";
$lang['next_friendly_match'] ="Next exhibition match on %data1 versus";
$lang['no_friendly_match'] ="No exhibition matchs are scheduled. <b>".anchor('friendly/index','Challenge your friends')."</b>!!!";
$lang['match_not_yet'] ="Your matchs are finished but the championship not yet. You can upgrade your team during this time.";
$lang['not_in_champ'] ="You are not in any championship ";
$lang['in_champ'] ="You are in";
$lang['not_valide_team'] ="You didn't confirm your team for the next match.";
$lang['valide_team'] ="Your team is confirmed for the next match";
$lang['bug_nok'] ="Bug hasn't been transmitted with succes because field is empty";
$lang['bug_ok'] ="Bug has been transmitted with succes";
$lang['bug_captcha'] ="Captcha is wrong";

//Notifications Accueil
$lang['welcome_game'] = "Welcome to DirtyFootball Manager. To begin, Join a championship and select your players then confirm your team.";
$lang['welcome_wollars'] = "DirtyFootball Federation offers you 1 000 000 de Wollars";
$lang['welcome_dirtygold'] = "DirtyFootball Federation offers you 5 DirtyGold";

//Notifications injury
$lang['injury'] = "<b>%data1</b> is injured. He can't play until <b>%data2</b>";


//Notifications Championship
$lang['join_championship'] = "Congratulation you just join <b>%data1</b> championship.Matchs will be scheduled when championship will be completed by ten teams. <b>".anchor('friends/index','Invite your friends')."</b>!!!";
$lang['championship_finished'] = "your championship is finished, your position is <b>%data1</b>. The three best teams go to next level, there are 3 levels (1 to 3). More details in honours list";
$lang['start_championship'] = "<b>%data1</b> championship has just begun, prepare yourself to the first matchs";
$lang['integration_championship'] ="join a championship";
$lang['confirm_team'] ="Confirm your team";

//Notifications Transfert
$lang['transfert_propose'] = "You have just received an offer for <b>".anchor('transferts/index#offers_received','%data1')."</b>";
$lang['transfert_modifie'] = "A team has modified her offer for <b>".anchor('transferts/index#offers_received','%data1')."</b>";
$lang['transfert_accepte'] = "Your offer for <b>".anchor('transferts/player_profil/%data2','%data1')."</b> has been accepted, you have a new player in your team";
$lang['transfert_refuse'] = "Your offer for <b>".anchor('transferts/player_profil/%data2','%data1')."</b> has been refused";
$lang['transfert_annule'] = "Your offer for <b>".anchor('transferts/player_profil/%data2','%data1')."</b> has been cancelled";

//Notifications Wollars
$lang['wollars_win'] = "You have just received %data1 Wollars thanks to your victory";
$lang['wollars_loose'] = "You have just received %data1 Wollars thanks to your defeat";
$lang['wollars_draw'] = "You have just received %data1 Wollars thanks to your tie match";

//Notifications corruption
$lang['corruption_propose'] = "%data1 wants to corrupt you, He wants to buy the next match %data2 Wollars. <b>".anchor('corruption/index#matchs','See corruption')."</b>";
$lang['corruption_accepte'] = "%data1 has accepted to be corrupted. You will earn %data2 Wollars";
$lang['corruption_refuse'] = "%data1 seems to be incorruptible and he refused your offer %data2 Wollars";
$lang['corruption_aborted'] = " you haven't got %data2 Wollars to corrupt %data1. Corruption is aborted!";

$lang['friendly_propose'] = "you have just received an exhibition match invitation. <b>".anchor('friendly/index#ask','See invitation')."</b>";
$lang['friendly_accepte'] = "%data1 has accepted your exhibition match. <b>".anchor('friendly/index#result','See calendar')."</b>";
$lang['friendly_refuse'] = "%data1 has refused your exhibition match.";

//stats
$lang['victory'] = " victories";
$lang['defeat'] = " defeats";
$lang['tie'] = " tie";

//options
$lang['holidays'] = " Holidays (1 DirtyGold): ";
$lang['validation_ok'] = " The assistant will confirm all your next matchs";
$lang['validation_dirtygold'] = " 1 DirtyGold is necessary to pay the assistant";
$lang['validation_bonus'] = "you can't use bonus when you are in holiday. You must delete bonus in use if you want to go away";
$lang['validation_back'] = " You are back!!";
$lang['validation_team_not_ready'] = " You must confirm your team before to go away!";
$lang['change_langage'] = " Change your language";
$lang['confirm_assistant'] = " Confirm your team automatically";
$lang['langage_french'] = " French";
$lang['langage_english'] = " English";

//details palmares
$lang['details_palmares_title'] = "Palmares details";
$lang['details_palmares_team'] = "Team";
$lang['details_palmares_position'] = "Final position";
$lang['details_palmares_pts'] = "PTS";

//bug tracker
$lang['bug_explain'] = "Explain your problem";
$lang['bug_validate'] = "Send";

?>
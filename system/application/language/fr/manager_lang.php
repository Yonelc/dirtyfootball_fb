<?php
//Sous menu
$lang['submenu_infos'] ="Informations";
$lang['submenu_complexe'] ="Complexe sportif";
$lang['submenu_palmares'] ="Palmares";
$lang['submenu_pantheon'] ="Panthéon";
$lang['submenu_options'] ="Options";
$lang['submenu_faq'] ="Faq";

//Progress bar
$lang['progress_champ'] ="Intégrer un championnat";
$lang['progress_compose'] ="Composer l'équipe";
$lang['progress_valide'] ="Matchs amicaux";

//Palmares tab
$lang['palmarestab_nom'] ="Nom du championnat";
$lang['palmarestab_position'] ="Position finale";
$lang['palmarestab_niveau'] ="Niveau";
$lang['palmarestab_date'] ="Date";

//Top
$lang['top_amis'] ="Top amis";
$lang['top_mondial'] ="Top mondial";
$lang['top_level'] ="nv ";

//Messages controller
$lang['match_program'] ="Les matchs seront programmés lorsque le championnat atteindra 10 équipes. Alors n'attendez plus <b>".anchor('friends/index','invitez vos amis')."</b>!!!";
$lang['match_not_yet'] ="Vos matchs sont terminés mais Le championnat n'est pas terminé. Profitez pour renforcer votre équipe pour la saison suivante";
$lang['next_match'] ="Prochain match de championnat le %data1 contre";
$lang['next_friendly_match'] ="Prochain match amical le %data1 contre";
$lang['no_friendly_match'] ="Aucun match amical n'a été programmé. <b>".anchor('friendly/index','Défi tes amis')."</b>!!!";
$lang['not_in_champ'] ="Vous n'appartenez à aucun championnat.";
$lang['in_champ'] ="Vous appartenez à";
$lang['not_valide_team'] ="Vous n'avez pas validé votre équipe pour le prochain match.";
$lang['valide_team'] ="Votre équipe est validée pour le prochain match";
$lang['bug_nok'] ="Votre bug n'a pas été soumis car le champs était vide";
$lang['bug_ok'] ="Votre bug a été soumis avec succès, nous allons le corriger prochainement. Merci pour votre contribution";
$lang['bug_captcha'] ="Le nombre de contrôle est erroné";

//Notifications Accueil
$lang['welcome_game'] = "Bienvenue sur DirtyFootball Manager. Pour débuter intégrez un championnat et composez votre équipe puis validez la.";
$lang['welcome_wollars'] = "La fédération DirtyFootball vous offre 1 000 000 de Wollars, faites en bon usage";
$lang['welcome_dirtygold'] = "La fédération DirtyFootball vous offre 5 DirtyGold. Attention à bien gérer vos DirtyGold car ils vous servent notamment à rejoindre ou créer des championnats!!";

//Notifications injury
$lang['injury'] = "<b>%data1</b> s'est blessé lors du dernier match. Il sera indisponible jusqu'au <b>%data2</b>";


//Notifications Championship
$lang['join_championship'] = "Félicitation vous venez de rejoindre le championnat <b>%data1</b>. Les matchs débuteront lorsque 10 équipes seront présentes. En attendant profitez pour améliorer votre équipe et <b>".anchor('friends/index','Invitez vos amis')."</b>!!!";
$lang['championship_finished'] = "Le championnat auquel vous participiez est maintenant terminé, vous avez terminé à la position <b>%data1</b>. Les 3 premiers accèdent en division de niveau supérieur et les 3 derniers descendent en division de niveau inférieur. Il y a 3 niveau (1 à 3). Pour plus de détails rendez dans la sous catégorie Palmares";
$lang['start_championship'] = "Le championnat <b>%data1</b> vient de débuter, préparez-vous aux premiers matchs";
$lang['integration_championship'] ="intégrer un championnat";
$lang['confirm_team'] ="Valider l'équipe";

//Notifications Transfert
$lang['transfert_propose'] = "Vous venez de recevoir une offre de transfert pour <b>".anchor('transferts/index#offers_received','%data1')."</b>";
$lang['transfert_modifie'] = "Une équipe a modifié son offre de transfert pour <b>".anchor('transferts/index#offers_received','%data1')."</b>";
$lang['transfert_accepte'] = "Votre demande de transfert pour <b>".anchor('transferts/player_profil/%data2','%data1')."</b> a été acceptée, vous disposez maintenant du nouveau joueur";
$lang['transfert_refuse'] = "Votre demande de transfert pour <b>".anchor('transferts/player_profil/%data2','%data1')."</b> a été refusée, l'offre ne convenait apparemment pas";
$lang['transfert_annule'] = "Le transfert pour <b>".anchor('transferts/player_profil/%data2','%data1')."</b> a été annulé";

//Notifications Wollars
$lang['wollars_win'] = "Vous venez de recevoir %data1 Wollars grâce à votre victoire au précédent match";
$lang['wollars_loose'] = "Vous venez de recevoir %data1 Wollars à cause de votre défaite au précédent match";
$lang['wollars_draw'] = "Vous venez de recevoir %data1 Wollars grâce à votre match nul au précédent match";

//Notifications corruption
$lang['corruption_propose'] = "%data1 tente de vous corrompre, en vous achetant le prochain match %data2 Wollars. <b>".anchor('corruption/index#matchs','Voir la tentative de corruption')."</b>";
$lang['corruption_accepte'] = "%data1 a accepté votre tentative de corruption. Vous allez donc gagner le prochain match pour %data2 Wollars";
$lang['corruption_refuse'] = "%data1 semble incorruptible et a refusé votre offre de %data2 Wollars";
$lang['corruption_aborted'] = " Vous n'avez plus %data2 Wollars pour corrompre %data1. La corruption est annulée!";


//Notifications Friendly
$lang['friendly_propose'] = "Vous venez de recevoir une invitation à un match amical. <b>".anchor('friendly/index#ask','Voir l\'invitation')."</b>";
$lang['friendly_accepte'] = "%data1 a accepté votre proposition de match amical. <b>".anchor('friendly/index#result','Voir le calendrier')."</b>";
$lang['friendly_refuse'] = "%data1 a refusé votre proposition de match amical.";


//stats
$lang['victory'] = " victores";
$lang['defeat'] = " défaites";
$lang['tie'] = " nuls";

//options
$lang['holidays'] = " Vacances (1 DirtyGold): ";
$lang['validation_ok'] = " L'assistant validera vos matchs pendant votre absence";
$lang['validation_dirtygold'] = " Il vous faut 1 DirtyGold pour payer l'assistant à la validation";
$lang['validation_bonus'] = "Vous ne pouvez pas utiliser de bonus lorsque vous partez en vacances. Vous devez supprimer les bonus utilisés.";
$lang['validation_back'] = " Vous êtes maintenant revenus de vacances";
$lang['validation_team_not_ready'] = " Vous devez valider votre équipe avant de partir en vacances!";
$lang['change_langage'] = " Changer de langue";
$lang['confirm_assistant'] = " Assistant de validation";
$lang['langage_french'] = " French";
$lang['langage_english'] = " English";

//details palmares
$lang['details_palmares_title'] = "Details du palmares";
$lang['details_palmares_team'] = "Equipe";
$lang['details_palmares_position'] = "Position finale";
$lang['details_palmares_pts'] = "PTS";

//bug tracker
$lang['bug_explain'] = "Expliquez votre problème de manière précise";
$lang['bug_validate'] = "Valider";
?>
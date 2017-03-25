<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class match_rules {

const homeTeam="H";
const awayTeam="A";
const drawMatch="D";


/*
|==========================================================
| Compare skills of the two teams
|==========================================================
|
*/
    public static function compare_skills($homeTeamExp,$awayTeamExp)
    {
        
        if($homeTeamExp>$awayTeamExp)
        {
            $compareResult=match_rules::homeTeam;

            //calcul the difference between two teams experience
            $gap=$homeTeamExp-$awayTeamExp;

            //
            $result=match_rules::gap_grid($gap,$compareResult);
        }

        if($homeTeamExp<$awayTeamExp)
        {
            $compareResult=match_rules::awayTeam;
            $gap=$awayTeamExp-$homeTeamExp;
            $result=match_rules::gap_grid($gap,$compareResult);
        }

        if($homeTeamExp==$awayTeamExp)
        {
            $compareResult=match_rules::drawMatch;
            $gap=0;
            $result=match_rules::gap_grid($gap,$compareResult);
        }

        return $result;

    }

/*
|==========================================================
| Compare capacity stadium
|==========================================================
|
*/
    public static function compare_stadium_capacity($homeTeamCapacity,$awayTeamCapacity)
    {

        $capacity=array();

        if($homeTeamCapacity>$awayTeamCapacity)
        {
            $capacity["home_capacity_points"]=1;
            $capacity["away_capacity_points"]=0;
        }

        if($homeTeamCapacity<$awayTeamCapacity)
        {
            $capacity["home_capacity_points"]=0;
            $capacity["away_capacity_points"]=1;

        }

        if($homeTeamCapacity==$awayTeamCapacity)
        {
            $capacity["home_capacity_points"]=0;
            $capacity["away_capacity_points"]=0;

        }

        return $capacity;

    }

/*
|==========================================================
| Calculate points depending on gap between skills
|==========================================================
|
*/
    public static function gap_grid($gap,$compareResult)
    {
        $resultArr=array();

        if($compareResult==match_rules::homeTeam){
            if($gap<=5)
            {
               $resultArr["home_team_points"]=2;
               $resultArr["away_team_points"]=0;
            }

            if($gap>5 && $gap<=10)
            {
               $resultArr["home_team_points"]=4;
               $resultArr["away_team_points"]=0;
            }

            if($gap>10 && $gap<=20)
            {
               $resultArr["home_team_points"]=6;
               $resultArr["away_team_points"]=0;
            }

            if($gap>20)
            {
               $resultArr["home_team_points"]=8;
               $resultArr["away_team_points"]=0;
            }

            if($gap==0)
            {
               $resultArr["home_team_points"]=1;
               $resultArr["away_team_points"]=1;
            }
        }

        if($compareResult==match_rules::awayTeam){
            if($gap<=5)
            {
               $resultArr["home_team_points"]=0;
               $resultArr["away_team_points"]=2;
            }

            if($gap>5 && $gap<=10)
            {
               $resultArr["home_team_points"]=0;
               $resultArr["away_team_points"]=4;
            }

            if($gap>10 && $gap<=20)
            {
               $resultArr["home_team_points"]=0;
               $resultArr["away_team_points"]=6;
            }

            if($gap>20)
            {
               $resultArr["home_team_points"]=0;
               $resultArr["away_team_points"]=8;
            }

            if($gap==0)
            {
               $resultArr["home_team_points"]=1;
               $resultArr["away_team_points"]=1;
            }
        }

        if($compareResult==match_rules::drawMatch && $gap==0){

            $resultArr["home_team_points"]=0;
            $resultArr["away_team_points"]=0;
        }

        return $resultArr;
    }

/*
|==========================================================
| Calculate total points for each team
|==========================================================
|
*/
    public static function total_points($stadiumCapacityPoints,
                                    $primaryAttackPoints,
                                    $primaryMiddlePoints,
                                    $primaryDefensePoints,
                                    $primaryGoalkeeperPoints,
                                    $secondaryAttackPoints,
                                    $secondaryMiddlePoints,
                                    $secondaryDefensePoints,
                                    $secondaryGoalkeeperPoints,
                                    $sectorHomeOffensive,
                                    $sectorAwayOffensive,
                                    /*$sectorMiddle,*/
                                    $successPoints,
                                    $globalPoints)
     {

        $resultPoints=array();

        $resultPoints["homeTeam"]=$stadiumCapacityPoints["home_capacity_points"]+
                                  $primaryAttackPoints["home_team_points"]+
                                  $primaryMiddlePoints["home_team_points"]+
                                  $primaryDefensePoints["home_team_points"]+
                                  $primaryGoalkeeperPoints["home_team_points"]+
                                  $secondaryAttackPoints["home_team_points"]+
                                  $secondaryMiddlePoints["home_team_points"]+
                                  $secondaryDefensePoints["home_team_points"]+
                                  $secondaryGoalkeeperPoints["home_team_points"]+
                                  $sectorHomeOffensive["home_team_points"]+
                                  $sectorAwayOffensive["home_team_points"]+
                                  /*$sectorMiddle["home_team_points"]+*/
                                  $successPoints["home_team_points"]+
                                  $globalPoints["home_team_points"];

        $resultPoints["awayTeam"]=$stadiumCapacityPoints["away_capacity_points"]+
                                  $primaryAttackPoints["away_team_points"]+
                                  $primaryMiddlePoints["away_team_points"]+
                                  $primaryDefensePoints["away_team_points"]+
                                  $primaryGoalkeeperPoints["away_team_points"]+
                                  $secondaryAttackPoints["away_team_points"]+
                                  $secondaryMiddlePoints["away_team_points"]+
                                  $secondaryDefensePoints["away_team_points"]+
                                  $secondaryGoalkeeperPoints["away_team_points"]+
                                  $sectorHomeOffensive["away_team_points"]+
                                  $sectorAwayOffensive["away_team_points"]+
                                  /*$sectorMiddle["home_team_points"]+*/
                                  $successPoints["away_team_points"]+
                                  $globalPoints["away_team_points"];

        return $resultPoints;

    }
    
/*
|==========================================================
| Success parameter (add some points to a team during the match)
|==========================================================
|
*/
    public static function success_parameter()
    {
        $success=array();
        //binary flag
        $hometeam=0;
        $awayTeam=1;
        //generate success points
        $successParameter=rand(0,2);
        //choose the lucky team
        $teamChoosen=rand($hometeam,$awayTeam);
        
        if($teamChoosen==$hometeam){
            
            $success["home_team_points"]=$successParameter;
            $success["away_team_points"]=0;
        
        }else{
        
            $success["away_team_points"]=$successParameter;
            $success["home_team_points"]=0;
        
        }

        return $success;

    }

/*
|==========================================================
| Calculate score,winner and looser and save in database
|==========================================================
|
*/
    public static function calcul_score($totalPoints)
    {

        if($totalPoints["homeTeam"]>$totalPoints["awayTeam"]+2){

            $gap=$totalPoints["homeTeam"]-$totalPoints["awayTeam"];
            $score=match_rules::score_grid($gap);
            $score["winner_team"]=match_rules::homeTeam;
            $score["looser_team"]=match_rules::awayTeam;
        }

        if($totalPoints["homeTeam"]<$totalPoints["awayTeam"]+2){
            
            $gap=$totalPoints["awayTeam"]-$totalPoints["homeTeam"];
            $score=match_rules::score_grid($gap);
            $score["winner_team"]=match_rules::awayTeam;
            $score["looser_team"]=match_rules::homeTeam;

        }

        if(($totalPoints["awayTeam"]-2<=$totalPoints["homeTeam"] && $totalPoints["homeTeam"]<=$totalPoints["awayTeam"]+2) || ($totalPoints["homeTeam"]-2<=$totalPoints["awayTeam"] && $totalPoints["awayTeam"]<=$totalPoints["homeTeam"]+2)){

            $gap=0;
            $score=match_rules::score_grid($gap);
            $score["draw_team1"]=match_rules::awayTeam;
            $score["draw_team2"]=match_rules::homeTeam;
        }

        return $score;

    }



/*
|==========================================================
| Score grid
|==========================================================
|
*/
    public static function score_grid($gap)
    {

        $scoreArr=array();

        if($gap<=5){

            $scoreArr["winner_goal"]=1;
            $scoreArr["looser_goal"]=0;
        }

        if($gap>5 && $gap<=10){

            $scoreArr["winner_goal"]=rand(2,3);
            $scoreArr["looser_goal"]=rand(0,1);

        }

        if($gap>10 && $gap<=15){

            $scoreArr["winner_goal"]=rand(2,3);
            $scoreArr["looser_goal"]=rand(0,1);

        }

        if($gap>15 && $gap<=20){

            $scoreArr["winner_goal"]=rand(3,4);
            $scoreArr["looser_goal"]=rand(0,2);

        }

        if($gap>20){

            $scoreArr["winner_goal"]=rand(4,5);
            $scoreArr["looser_goal"]=rand(0,2);

        }

        if($gap==0){

            $scoreArr["winner_goal"]=rand(0,4);
            $scoreArr["looser_goal"]=$scoreArr["winner_goal"];

        }

        return $scoreArr;

    }


    /*
|==========================================================
| Match winner
|==========================================================
|
*/
    public static function match_winner($homeTeam,$awayTeam,$score)
    {
        $result=array();

        if(isset($score['winner_team']) && $score['winner_team']==match_rules::homeTeam)
        {
            $result["winner"]=$homeTeam;
            $result["home_team_score"]=$score['winner_goal'];
            $result["looser"]=$awayTeam;
            $result["away_team_score"]=$score['looser_goal'];
            $result["draw"]="";
        }

        if(isset($score['winner_team']) && $score['winner_team']==match_rules::awayTeam)
        {
            $result["winner"]=$awayTeam;
            $result["away_team_score"]=$score['winner_goal'];
            $result["looser"]=$homeTeam;
            $result["home_team_score"]=$score['looser_goal'];
            $result["draw"]="";
        }

        if(!isset($score['winner_team']))
        {
            $result["winner"]="";
            $result["away_team_score"]=$score['winner_goal'];
            $result["looser"]="";
            $result["home_team_score"]=$score['looser_goal'];
            $result["draw"]="y";
        }

        return $result;

    }

    /*
|==========================================================
| Match comments
|==========================================================
|
*/
    public static function getLevelComments($result,$score)
    {

        $gap=$score["winner_goal"]-$score["looser_goal"];

                
        if($gap==0)
        {
            $levelComments=0;
        }

        if($gap==1)
        {
            $levelComments=1;
        }

        if($gap==2)
        {
            $levelComments=2;
        }

        if($gap==3)
        {
            $levelComments=3;
        }

        if($gap>3)
        {
            $levelComments=4;
        }

        return $levelComments;

    }
}

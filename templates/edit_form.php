<div id="view_form" style="width: 100%">
    <h1 class="center"><?= strtoupper($_SESSION["school_name"]) . " " . $all["team_name1"] . "-" . $all["team_name2"] ?></h1>
    <h3 class="center"><?= $all["tournament_name"] . " " . $all["tournament_year"] . " - " . "Round " . $GLOBALS["OUTROUNDS"][$all["round_num"]] ?></h3>
    
    <h3 class="center">
    <?php
        if($all["report_side"] == 1)
        {
            print("AFF v. ");
        }
        else
        {
            print("NEG v. ");
        }

        print($all["report_opp"]); 
    ?>
    </h3>
    <h3 class="center">
        <?php
            if(empty($judges[1]))
            {
                print($all["judge_first"] . " " . $all["judge_last"] . " voted "); 
            }
            else
            {
                end($judges); 
                $last_judge = key($judges); 
                
                foreach($judges as $key => $judge)
                {
                    if($key != $last_judge)
                    {
                        print(substr($judge["judge_first"], 0, 1) . " " . $judge["judge_last"] . ", "); 
                    }
                    else
                    {
                        print(substr($judge["judge_first"], 0, 1) . " " . $judge["judge_last"] . " "); 
                    }
                }
                
                print("decided "); 
            }
                if(($all["report_side"] == 1 && $all["report_result"] == 1) || ($all["report_side"] != 1 && $all["report_result"] != 1))
                {
                    print("AFF"); 
                }
                else
                {
                    print("NEG"); 
                }
        ?>
    </h3>
    <div class="padding"></div>
    <div id="round_info">
        <div class="info_header">AFF:</div>
        <div class="info_body"><?= $all["report_aff"] ?></div>
        <div class="info_header">1NC:</div>
        <div class="info_body"><?= $all["report_1nc"] ?></div>
        <div class="info_header">2NC:</div>
        <div class="info_body"><?=$all["report_2nc"]?></div>
        <div class="info_header">1NR:</div>
        <div class="info_body"><?=$all["report_1nr"]?></div>
        <div class="info_header">2NR:</div>
        <div class="info_body"><?=$all["report_2nr"]?></div>
        <div class="info_header">AFF Strat:</div>
        <div class="info_body"><?=$all["report_aff_strat"]?></div>
        <div class="info_header">Comments/RFD:</div>
        <div class="info_body">
            <?php
                $paragraphs = explode("\n", $all["report_comments"]); 
                
                foreach($paragraphs as $paragraph)
                {
                    print("<p>" . $paragraph . "</p>"); 
                }
            ?>
        </div>
    </div>
    <div style="padding: 20px"></div>
    <div class="center">
        <button class="center" id="edit_button">Edit Round</button>
    </div>
</div>
<div class="padding"></div>
<div id="edit_form">
<h1 class="center">Edit Report</h1>
<form action="edit.php" method="post">
<input name="report_id" <?= "value=\"" . $all["report_id"] . "\"" ?> type="hidden" />
    <div class="form_field">
        <div class="field_title">Team</div>
        <select name="team">
            <?= "<option value=\"" . $all["team_id"] . "\">" . $all["team_name1"] . "-" . $all["team_name2"] . "</option>" ?>
            <?php
                $teams = query("SELECT * FROM teams WHERE school_id = ? AND team_on=1 AND team_del!=1 ORDER BY team_name1", $_SESSION["id"]); 
                            
                foreach($teams as $team)
                {
                    print("<option value=\"" . $team["team_id"] . "\">" . $team["team_name1"] . "-" . $team["team_name2"] . "</option>");
                }
            ?>                    
        </select>
    </div>
    <div class="form_field">
        <div class="field_title">Tournament</div>
        <select name="tournament">
            <?= "<option value=\"" . $all["tournament_id"] . "\">" . $all["tournament_name"] . " " . $all["tournament_year"] . "</option>" ?>
            <?php
                $tournaments = query("SELECT * FROM attendance JOIN tournaments ON attendance.tournament_id = tournaments.tournament_id WHERE attendance.school_id = ? AND attend_on=1 AND attend_del != 1 ORDER BY tournaments.tournament_name", $_SESSION["id"]); 
       
                foreach($tournaments as $tournament)
                {
                    if($tournament["tournament_id"] != $all["tournament_id"])
                    {
                        print("<option value=\"" . $tournament["tournament_id"] . "\">" . $tournament["tournament_name"] . " " . $tournament["tournament_year"] . "</option>");
                    }
                }
             ?>
        </select>
    </div>
    <div class="form_field">
        <div class="field_title">Round</div>
        <select name="round">
            <?= "<option value=\"" . $all["round_num"] . "\">" . $GLOBALS["OUTROUNDS"][$all["round_num"]] . "</option>" ?>
            <?php print_rounds("select"); ?>
        </select>
    </div>
    <div class="form_field">
        <div class="field_title">Your Side</div>
        <div class="field">
            <input <?php if($all["report_side"] == 1) print("checked=\"checked\""); ?> id="aff" type="radio" name="side" value="1" />
            <label for="aff">Aff</label>
        </div>
        <div class="field">
            <input <?php if($all["report_side"] != 1) print("checked=\"checked\""); ?> id="neg" type="radio" name="side" value="2" />
            <label for="neg">Neg</label>
        </div>
    </div>
    <div class="form_field">
        <div class="field_title">Opponent</div>
        <input <?= "value=\"" . $all["report_opp"] . "\"" ?> name="opp" type="text"/>
    </div>
    <div class="form_field">
        <div class="field_title">Result</div>
        <div class="field">
            <input <?php if($all["report_result"] == 1) print("checked=\"checked\""); ?> id="win" type="radio" name="result" value="1" />
            <label for="win">Win</label>
        </div>
        <div class="field">
            <input <?php if($all["report_result"] != 1) print("checked=\"checked\""); ?> id="loss" type="radio" name="result" value="2" />
            <label for="loss">Loss</label>
        </div>
    </div>
    <div class="form_field">
        <div class="field_title">Judge</div>
        <textarea name="judges" wrap="soft" cols="50" rows="2"><?php
            foreach($judges as $judge)
            {
                if(!empty($judge))
                {
                    print($judge["judge_first"]." ".$judge["judge_last"]."; "); 
                }
            }
        ?></textarea>
    </div>
    <div class="form_field">
        <div class="field_title">Aff</div>
        <textarea name="aff" wrap="soft" cols="50" rows="2" placeholder="(seperate categories with semicolon) e.g. sps; space lead: debris, heg; aerospace industry: econ"><?= $all["report_aff"] ?></textarea>
    </div>
    <div class="form_field">
        <div class="field_title">1nc</div>
        <textarea name="1nc" wrap="soft" cols="50" rows="2" placeholder="(seperate categories with semicolon) e.g. t - commercial; weaponization da; heg bad; case d"><?= $all["report_1nc"] ?></textarea>
    </div>
    <div class="form_field">
        <div class="field_title">2nc</div>
        <textarea name="2nc" wrap="soft" cols="50" rows="2" placeholder="(seperate categories with semicolon) e.g. t - commercial; heg bad"><?= $all["report_2nc"] ?></textarea>
    </div>
    <div class="form_field">
        <div class="field_title">1nr</div>
        <textarea name="1nr" wrap="soft" cols="50" rows="2" placeholder="(seperate categories with semicolon) e.g. weaponization; case"><?= $all["report_1nr"] ?></textarea>
    </div>
    <div class="form_field">
        <div class="field_title">2nr</div>
        <textarea name="2nr" wrap="soft" cols="50" rows="2" placeholder="(seperate categories with semicolon) e.g. weaponization da"><?= $all["report_2nr"] ?></textarea>
    </div>
    <div class="form_field">
        <div class="field_title">Aff Strat</div>
        <textarea name="aff_strat" wrap="soft" cols="50" rows="2" placeholder="(seperate categories with semicolon) e.g. 2ac: china add-on; 1ar: straight-t/ wpnztion"><?= $all["report_aff_strat"] ?></textarea>
    </div>
    <div class="form_field">
        <div class="field_title">Comments</div>
        <textarea name="comments" wrap="soft" cols="50" rows="7" placeholder="type!"><?= $all["report_comments"] ?></textarea>
    </div>
    <div class="padding"></div>
    <div class="center">
                <button type="submit">Submit</button>
                <button type="reset" id="cancel_button">Cancel</button>
    </div>
    <div class="padding"></div>
</form>
</div>
<script>
    // onready
    $(document).ready(function() {
        
        // hide the edit form
        $('#edit_form').hide(); 
        
        // on choosing to edit
        $('#edit_button').click(function() {
         
            // hide the view form
            $('#view_form').hide();
         
            // show the edit form
            $('#edit_form').show();     
        
        }); 
                
        // on cancelling
        $('#cancel_button').click(function() {
         
            // hide the edit form
            $('#edit_form').hide();
         
            // show the view form
            $('#view_form').show();
        }); 
    });
</script>

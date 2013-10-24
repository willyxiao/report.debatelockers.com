<h1 class="center">Add Tournament</h1>
<div class="padding"></div>
<form action="tournaments.php" method="post">
        <div class="center">
            <select autofocus name="tournament">
                <option value></option>
                <?php
                    // if the school has attended tournaments
                    if(isset($attends[0]))
                    {
                        // save the tournaments in an array to display
                        foreach($tournaments as $tournament)
                        {
                            $displays[$tournament["tournament_id"]] = $tournament;
                            
                            // mark the display as false if the school has already added that tournament
                            foreach($attends as $attend)
                            {
                                if($tournament["tournament_id"] === $attend["tournament_id"])
                                {
                                    $displays[$tournament["tournament_id"]] = false; 
                                }
                            }
                        }
                        
                        // display the tournaments
                        foreach($displays as $display)
                        {
                            if($display != false)
                            {
                                print("<option value=\"" . $display["tournament_id"] . "\">" . $display["tournament_name"] . " " . $display["tournament_year"] . "</option>");
                            }
                        }
                    }
                    // if the school hasn't attended any tournaments yet - list all the available tournaments
                    else
                    {
                        foreach($tournaments as $tournament)
                        {
                            print("<option value=\"" . $tournament["tournament_id"] . "\">". $tournament["tournament_name"]. " " . $tournament["tournament_year"] . "</option>");
                        }
                    }
                ?>
            </select>
        </div>
        <div class="padding"></div>
        <div class="center">
            <button type="submit">Add</button>
        </div>
</form>
<div class="padding"></div>
<div class="toggle">
    <h1>Tournaments On</h1>
    <?php
        global $attend_offs; 
        
        foreach($attends as $attend)
        {
            if($attend["attend_on"] == 1)
            {
                $attend_ons[] = $attend; 
            }
            else
            {
                $attend_offs[] = $attend; 
            }
        }
        
        if(empty($attend_ons))
        {
            print("<h3>[none found]</h3>"); 
        }
        else
        {
            foreach($attend_ons as $attend)
            {            
                {
                    // tournament names
                    print("<div class=\"togrow\"><div class=\"togname\">" . $attend["tournament_name"] . " " . $attend["tournament_year"] . "</div>"); 
                    
                    // toggle option
                    print("<div class=\"togoptions\"><form action=\"toggle_tournament.php\" method=\"POST\"><input type=\"hidden\" name=\"toggle_off\" value=\"" . $attend["tournament_id"] . "\"/><button class=\"option1\" type=\"submit\">[on/off]</button></form></div>");
                    
                    // delete option
                    print("<div class=\"togoptions\"><form action=\"toggle_tournament.php\" method=\"POST\"><input type=\"hidden\" name=\"del\" value=\"" . $attend["tournament_id"] . "\"/><button class=\"option2\" type=\"submit\">[del]</button></form></div></div>"); 
                }
            }
        }
    ?>
    <div class="padding"></div>
    <h1>Tournaments Off</h1>
    <?php
        if(empty($attend_offs))
        {
            print("<h3>[none found]</h3>"); 
        }
        else
        {
            foreach($attend_offs as $attend)
            {            
                {
                    // tournament names
                    print("<div class=\"togrow\"><div class=\"togname\">" . $attend["tournament_name"] . " " . $attend["tournament_year"] . "</div>"); 
                    
                    // toggle option
                    print("<div class=\"togoptions\"><form action=\"toggle_tournament.php\" method=\"POST\"><input type=\"hidden\" name=\"toggle_on\" value=\"" . $attend["tournament_id"] . "\"/><button class=\"option1\" type=\"submit\">[on/off]</button></form></div>");
                    
                    // delete option
                    print("<div class=\"togoptions\"><form action=\"toggle_tournament.php\" method=\"POST\"><input type=\"hidden\" name=\"del\" value=\"" . $attend["tournament_id"] . "\"/><button class=\"option2\" type=\"submit\">[del]</button></form></div></div>"); 
                }
            }
        }
    ?>
</div>
<div class="padding"></div>

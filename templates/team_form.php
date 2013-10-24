<h1 class="center">Add Team</h1>
<div class="padding"></div>
    <form action="teams.php" method="post">
        <div class="center" style="width: 300px">
            <div class="form_field">
                <div class="field_title">Debater 1</div>
                <input autofocus name="name1" placeholder="Last Name Only" type="text"/>
            </div>
            <div class="form_field">
                <div class="field_title">Debater 2</div>
                <input name="name2" placeholder="Last Name Only" type="text"/>
            </div>
        </div>
        <div class="padding"></div>
        <div class="center">
           <button type="submit">Add Team</button>
        </div>
    </form>
<div class="padding"></div>
<div class="toggle">
    <h1>Teams On</h1>
        <?php
            if(empty($on_teams))
            {
                print("<h3>[none found]</h3>"); 
            }

            // prints all of the teams that are on
            foreach($on_teams as $teams)
            {
                // team names
                print("<div class=\"togrow\"><div class=\"togname\">" . $teams["team_name1"] . "-" . $teams["team_name2"] . "</div>"); 
                
                // toggle option
                print("<div class=\"togoptions\"><form action=\"toggle_team.php\" method=\"POST\"><input type=\"hidden\" name=\"toggle_off\" value=\"" . $teams["team_id"] . "\"/><button class=\"option1\" type=\"submit\">[on/off]</button></form></div>");
                
                // delete option
                print("<div class=\"togoptions\"><form action=\"toggle_team.php\" method=\"POST\"><input type=\"hidden\" name=\"del\" value=\"" . $teams["team_id"] . "\"/><button class=\"option2\" type=\"submit\">[del]</button></form></div></div>"); 
            }
        ?>
    <div class="padding"></div>
    <h1>Teams Off</h1>
        <?php
            if(empty($off_teams))
            {
                print("<h3>[none found]</h3>"); 
            }
            
            // prints all of the teams that are off
            foreach($off_teams as $teams)
            {
                // team names
                print("<div class=\"togrow\"><div class=\"togname\">" . $teams["team_name1"] . "-" . $teams["team_name2"] . "</div>"); 
                
                // toggle option
                print("<div class=\"togoptions\"><form action=\"toggle_team.php\" method=\"POST\"><input type=\"hidden\" name=\"toggle_on\" value=\"" . $teams["team_id"] . "\"/><button class=\"option1\" type=\"submit\">[on/off]</button></form></div>");
                
                // delete option
                print("<div class=\"togoptions\"><form action=\"toggle_team.php\" method=\"POST\"><input type=\"hidden\" name=\"del\" value=\"" . $teams["team_id"] . "\"/><button class=\"option2\" type=\"submit\">[del]</button></form></div></div>");
            }
        ?>
</div>
<div class="padding"></div>

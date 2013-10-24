<h1 class="center">Report</h1>

<form action="report.php" method="post">
<div class="fixed">
    <div class="form_field">
        <div class="field_title">Team*</div>
        <select name="team">
            <option value></option>
            <?php                            
                foreach($teams as $team)
                {
                    print("<option value=\"" . $team["team_id"] . "\">" . $team["team_name1"] . "-" . $team["team_name2"] . "</option>");
                }
            ?>
        </select>
    </div>
    <div class="form_field">
        <div class="field_title">Tournament*</div>
        <select name="tournament">
            <option value></option>
            <?php                
                foreach($tournaments as $tournament)
                {
                    print("<option value=\"" . $tournament["tournament_id"] . "\">" . $tournament["tournament_name"] . " " . $tournament["tournament_year"] . "</option>");
                }
            ?>
        </select>
    </div>
    <div class="form_field">
        <div class="field_title">Round*</div>
        <select name="round">
            <option value></option>
                <?php print_rounds("select"); ?>
        </select>
    </div>
    <div class="form_field">
        <div class="field_title">Your Side*</div>
        <div class="field">
            <input type="radio" id="aff" name="side" value="1" checked="checked"/>
            <label for="aff">Aff</label>
        </div>
        <div class="field">
            <input type="radio" id="neg" name="side" value="2"/>
            <label for="neg">Neg</label>
        </div>
    </div>
    <div class="form_field">
        <div class="field_title">Opponent*</div>
        <input name="opp" placeholder="Format: school xx" type="text"/>
    </div>
    <div class="form_field">
        <div class="field_title">Result*</div>
        <div class="field">
            <input type="radio" id="win" name="result" value="1" checked="checked"/>
            <label for="win">Win</label>
        </div>
        <div class="field">
            <input type="radio" id="loss" name="result" value="2"/>        
            <label for="loss">Loss</label>
        </div>
    </div>
    <div class="form_field">
        <div class="field_title">Judge*</div>
        <textarea name="judges" wrap="soft" cols="50" rows="2" placeholder="firstname1 lastname1; firstname2 lastname2; etc., (MAX 5)"></textarea>
    </div>
    <div class="form_field">
        <div class="field_title">Aff</div>
        <textarea name="aff" wrap="soft" cols="50" rows="2" placeholder="(seperate categories with semicolon) e.g. sps; space lead: debris, heg; aerospace industry: econ"></textarea>
    </div>
    <div class="form_field">
        <div class="field_title">1nc</div>
        <textarea name="1nc" wrap="soft" cols="50" rows="2" placeholder="(seperate categories with semicolon) e.g. t - commercial; weaponization da; heg bad; case d"></textarea>
    </div>
    <div class="form_field">
        <div class="field_title">2nc</div>
        <textarea name="2nc" wrap="soft" cols="50" rows="2" placeholder="(seperate categories with semicolon) e.g. t - commercial; heg bad"></textarea>
    </div>
    <div class="form_field">
        <div class="field_title">1nr</div>
        <textarea name="1nr" wrap="soft" cols="50" rows="2" placeholder="(seperate categories with semicolon) e.g. weaponization; case"></textarea>
    </div>
    <div class="form_field">
        <div class="field_title">2nr</div>
        <textarea name="2nr" wrap="soft" cols="50" rows="2" placeholder="(seperate categories with semicolon) e.g. weaponization da"></textarea>
    </div>
    <div class="form_field">
        <div class="field_title">Aff Strat</div>
        <textarea name="aff_strat" cols="50" rows="2" wrap="soft" placeholder="(seperate categories with semicolon) e.g. 2ac: china add-on; 1ar: straight-t/ wpnztion"></textarea>
    </div>
    <div class="form_field">
        <div class="field_title">Comments</div>
            <textarea name="comments" cols="50" rows="7" wrap="soft" placeholder="Just Type! (if more than one judge, include decision and judges that sit)"></textarea>
    </div>
</div>
    <div class="padding"></div>
    <div class="center">
            <button type="submit">Enter Report</button>
    </div>
    <div class="padding"></div>
</form>


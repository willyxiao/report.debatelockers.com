<h1 class="center">Full Search</h1>
<div class="padding"></div>
<h3 class="center">Search all of your rounds - by any field.</h3>
<div class="padding"></div>
<div class="fixed">
<form action="search.php" method="POST">
    <?php
        foreach($fields as $field => $value)
        {
            for($i = 0; $i < 5; $i++)
            {
                if($i == 0 )
                {
                    print("<div id=\"" . $field . $i . "\" class=\"form_field\">"); 
                }
                else
                {
                    print("<div id=\"" . $field . $i . "\" class=\"form_field extra\">");                     
                }            
                    
                if($i == 0)
                {
                    print("<div class=\"field_title\">" . $field . "</div>");
                    print("<input name=\"" . $field . $i . "\" type=\"text\" placeholder=\"" . $field. " Name\" /></div>");  
                }
                else
                {
                    print("<input name=\"" . $field . $i . "\" placeholder=\"<OR> Another " . $field . "\" type=\"text\" /></div>"); 
                }
            }
            
            print("<div id=\"add_" . $field . "\" class=\"search_adder\"> [Add " . $field . " Field]</div>"); 
            print("<div class=\"padding\"></div>"); 
        }
    ?>
    <div class="form_field">
        <div class="field_title">Side</div>
        <select name="side">
            <option value=""></option>
            <option value="1">AFF</option>
            <option value="2">NEG</option>
        </select>
    </div>
    <div class="form_field">
        <div class="field_title">Result</div>
        <select name="result">
            <option value=""></option>
            <option value="1">WIN</option>
            <option value="2">LOSS</option>
        </select>
    </div>
    <div class="form_field">
        <div class="field_title">Rounds</div>
            <div class="field_checkbox">
                <?php print_rounds("checkbox") ?>
            </div>
    </div>
    <div class="center">
        <button type="submit">Search</button>
    </div>
</form>
</div>
<div class="padding"></div>
<script>
    // onready
    $(document).ready(function() 
    {
        // hide all of the extra fields
        $('.extra').hide();
                
        // initializes the number of shown fields
        var shown = {"Team":1, "Tournament":1, "Judge":1, "Opponent":1}; 
        
        // when a search adder is clicked
        $('.search_adder').click(function()
        {
            // gets the type of the clicked button
            var type = this.id.substring(4);
                    
            // makes the id of the div to show
            toshow = "#" + type + shown[type];
                    
            // shows the div
            $(toshow).show(); 
                    
            // iterates the number shown
            shown[type]++; 
                    
            // if all of the fields are shown, then don't let more be shown
            if(shown[type] == 5)
            {
                // hides the button to add more
                $(this).hide(); 
            }
        }); 
    }); 
</script>

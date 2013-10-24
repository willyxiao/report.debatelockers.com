<h1 class="center">Manage Updates</h1>
<div class="padding"></div>
<h3 class="center">Get instant updates to any report - you're welcome.</h3>
<div class="splitter"></div>
<h1 class="center">Emails</h1>
<div class="padding"></div>
    <form action="add_email.php" method="POST">
        <div class="center" style="width: 300px">
            <div class="form_field">
                <div class="field_title">Email:</div>
                <input name="email" placeholder="email@example.com" type="text"/>
            </div>
        </div>
        <div class="padding"></div>
        <div class="center">
           <button type="submit">Add Email</button>
        </div>
    </form>
<div class="padding"></div>
<div id="emails" class="toggle">
    <h1>Emails On</h1>
        <?php
            global $email_offs; 
        
            foreach($emails as $email)
            {
                if($email["email_on"] == 1)
                {
                    $email_ons[] = $email; 
                }
                else
                {
                    $email_offs[] = $email; 
                }
            }

            if(empty($email_ons))
            {
                print("<h3>[none found]</h3>"); 
            }
            else
            {
                // prints all of the emails
                foreach($email_ons as $email)
                {
                    // email names
                    print("<div class=\"togrow\"><div class=\"togname\">" . $email["email_email"] . "</div>"); 
                    
                    // toggle option
                    print("<div class=\"togoptions\"><form action=\"toggle_email.php\" method=\"POST\"><input type=\"hidden\" name=\"toggle_off\" value=\"" . $email["email_email"] . "\"/><button class=\"option1\" type=\"submit\">[on/off]</button></form></div>");
                    
                    // delete option
                    print("<div class=\"togoptions\"><form action=\"toggle_email.php\" method=\"POST\"><input type=\"hidden\" name=\"del\" value=\"" . $email["email_email"] . "\"/><button class=\"option2\" type=\"submit\">[del]</button></form></div></div>"); 
                }
            }
        ?>
    <div class="padding"></div>
    <h1>Emails Off</h1>
        <?php
            if(empty($email_offs))
            {
                print("<h3>[none found]</h3>"); 
            }
            else
            {
                // prints all of the teams that are off
                foreach($email_offs as $email)
                {
                    // team names
                    print("<div class=\"togrow\"><div class=\"togname\">" . $email["email_email"] . "</div>"); 
                    
                    // toggle option
                    print("<div class=\"togoptions\"><form action=\"toggle_email.php\" method=\"POST\"><input type=\"hidden\" name=\"toggle_on\" value=\"" . $email["email_email"] . "\"/><button class=\"option1\" type=\"submit\">[on/off]</button></form></div>");
                    
                    // delete option
                    print("<div class=\"togoptions\"><form action=\"toggle_email.php\" method=\"POST\"><input type=\"hidden\" name=\"del\" value=\"" . $email["email_email"] . "\"/><button class=\"option2\" type=\"submit\">[del]</button></form></div></div>");
                }
            }
        ?>
</div>
<div class="center">(Check your spam).</div>
<div class="splitter"></div>
<h1 class="center">SMS Numbers</h1>
<div class="padding"></div>
    <form action="add_number.php" method="POST">
        <div class="center" style="width: 300px">
            <div class="form_field">
                <div class="field_title">Number:</div>
                <input name="number" placeholder="##########" type="text"/>
            </div>
            <div class="form_field">
                <div class="field_title">Carrier:</div>
                <select name="provider">
                    <option value=""></option>
                    <?
                        foreach($providers as $provider)
                        {
                            print("<option value=\"" . $provider["sms_provider_id"] . "\">" . $provider["sms_provider_name"] . "</option>"); 
                        }
                    ?>
                </select>
            </div>
        </div>
        <div class="padding"></div>
        <div class="center">
           <button type="submit">Confirm Number</button>
        </div>
    </form>
<div class="padding"></div>
<div id="numbers" class="toggle">
    <h1>Numbers On</h1>
        <?php
            global $number_offs; 
        
            foreach($numbers as $number)
            {
                if($number["sms_on"] == 1)
                {
                    $number_ons[] = $number; 
                }
                else
                {
                    $number_offs[] = $number; 
                }
            }

            if(empty($number_ons))
            {
                print("<h3>[none found]</h3>"); 
            }
            else
            {
                // prints all of the numbers
                foreach($number_ons as $number)
                {
                    // numbers
                    print("<div class=\"togrow\"><div class=\"togname\">" . substr($number["sms_number"], 0, 3) . "-" . substr($number["sms_number"], 3, 3) . "-" . substr($number["sms_number"], 6, 4) . "</div>"); 
                    
                    // toggle option
                    print("<div class=\"togoptions\"><form action=\"toggle_number.php\" method=\"POST\"><input type=\"hidden\" name=\"toggle_off\" value=\"" . $number["sms_number"] . "\"/><button class=\"option1\" type=\"submit\">[on/off]</button></form></div>");
                    
                    // delete option
                    print("<div class=\"togoptions\"><form action=\"toggle_number.php\" method=\"POST\"><input type=\"hidden\" name=\"del\" value=\"" . $number["sms_number"] . "\"/><button class=\"option2\" type=\"submit\">[del]</button></form></div></div>"); 
                }
            }
        ?>
    <div class="padding"></div>
    <h1>Numbers Off</h1>
        <?php
            if(empty($number_offs))
            {
                print("<h3>[none found]</h3>"); 
            }
            else
            {
                // prints all of the teams that are off
                foreach($number_offs as $number)
                {
                    // numbers
                    print("<div class=\"togrow\"><div class=\"togname\">" . substr($number["sms_number"], 0, 3) . "-" . substr($number["sms_number"], 3, 3) . "-" . substr($number["sms_number"], 6, 4) . "</div>"); 
                    
                    // toggle option
                    print("<div class=\"togoptions\"><form action=\"toggle_number.php\" method=\"POST\"><input type=\"hidden\" name=\"toggle_on\" value=\"" . $number["sms_number"] . "\"/><button class=\"option1\" type=\"submit\">[on/off]</button></form></div>");
                    
                    // delete option
                    print("<div class=\"togoptions\"><form action=\"toggle_number.php\" method=\"POST\"><input type=\"hidden\" name=\"del\" value=\"" . $number["sms_number"] . "\"/><button class=\"option2\" type=\"submit\">[del]</button></form></div></div>"); 
                }
            }
        ?>
</div>
<div class="splitter"></div>
<script>
    // onready
    $(document).ready(function() {
        
        // on input into number field
        $('input[name|="number"]').keyup(function() {
            
            // gets the value of the search input
            var input = $(this).val(); 
            
            // iterates over all of the rows
            $('#numbers .togrow').each(function() {
                                
                // gets the html in each name and value
                var name = $(this).children('.togname').html(); 
                var value = $(this).find('input[type|="hidden"]').val(); 
                                           
                // if the input is in either the input or the name
                if(name.indexOf(input) !== -1 || value.indexOf(input) !== -1)
                {
                    // show the row
                    $(this).show();
                }
                // else hide the row
                else
                {
                    $(this).hide();
                }
            }); 
        }); 

        // on input into email field
        $('input[name|="email"]').keyup(function() {
            
            // gets the value of the search input
            var input = $(this).val().toLowerCase(); 
            
            // iterates over all of the rows
            $('#emails .togrow').each(function() {
                                
                // gets the html in each name and value
                var name = $(this).children('.togname').html(); 
                var value = $(this).find('input[type|="hidden"]').val(); 
                            
                // if the input is in either the input or the name
                if(name.indexOf(input) !== -1 || value.indexOf(input) !== -1)
                {
                    // show the row
                    $(this).show();
                }
                // else hide the row
                else
                {
                    $(this).hide();
                }             
            }); 
        }); 
    }); 
</script>

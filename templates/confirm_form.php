<h1 class="center">Confirmation</h1>
<div class="padding"></div>
<div style="font-weight: 900; position: relative; left: 20px">Code sent to <?= $_SESSION["code"]["number"] ?></div>
<div class="padding"></div>
<?php
    if($type == "sms")
    {
        print("<form action=\"add_number.php\" method=\"POST\">"); 
    }
?>
    <div class="form_field">
        <div class="field_title">Verify Code:</div>
        <input type="text" name="code" autofocus/>
    </div>
    <div style="position: relative; left: 30px; width: 100px; padding: 20px">
        <button type="submit">Enter</button>
    </div>
</form>
<div class="padding"></div>

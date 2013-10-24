<h1 class="center">Downloading the Template</h1>
<div class="padding"></div>
<script>
    // onReady
    $(document).ready(function () 
    {
        // hide all of the extras
        $(".extra").hide(); 

        // number shown        
        var shown = 1; 
        
        // hides the step backward option
        $("#step_backward").hide(); 
        
        // on click of forward
        $("#step_forward").click(function()
        {
            // show step backwards
            $("#step_backward").show();

            // show/hide the correct div
            var id = "#step" + shown;
            $(id).hide(); 
            shown++; 
            id = "#step" + shown; 
            $(id).show();
            
            // show/hide the next button
            if(shown == 5)
            {
                $(this).hide();
            }
            else
            {
                $(this).show();                
            }
        }); 
        
        // on click of backward
        $("#step_backward").click(function()
        {
            // show step forward
            $("#step_forward").show();

            // show/hide the correct div
            var id = "#step" + shown;
            $(id).hide(); 
            shown--; 
            id = "#step" + shown; 
            $(id).show();
            
            // show/hide the back button
            if(shown == 1)
            {
                $(this).hide();
            }
            else
            {
                $(this).show();
            }
        }); 
    }); 
</script>
<h3 class="center">Access all of your rounds - without internet.</h3>

<div class="step" id="step1">
    <div class="step_title">Step 1: Download + Open Template</div>
    <div class="padding"></div>
    <a class="instruction" href="download_template.php">Click here to download .xltx</a>
    <div class="padding"></div>
    <div class="image">
        <img src="images/template/dl1.png" alt="Download image." width="400px" height="150px" />
    </div>
    <div class="instruction">Double-click on the template to open it.</div>
    <div class="image">
        <img src="images/template/dl2.png" alt="Opened image." width="500px" height="500px" />
    </div>
</div>
<div class="step extra" id="step2">
    <div class="step_title">Step 2: Download Round Reports</div>
    <div class="padding"></div>
    <a class="instruction" href="download_reports.php">Click here to download .csv</a>
    <div class="padding"></div>
    <div class="image">
        <img src="images/template/dl3.png" alt="Download image." width="700px" height="500px" />
    </div>
    <div class="instruction">Or you can do a search to download specific rounds through: </div>
    <div class="center">
        <a style="display: inline-block; font-size: 10pt; padding-bottom: 20px" href="search.php">[Full Search]</a>
    </div>
</div>
<div class="step extra" id="step3">
    <div class="step_title">Step 3: Open .csv File</div>
    <div class="instruction">Open the .csv file with excel.</div>
    <div class="image">
        <img src="images/template/dl4.png" alt="Opening csv." width="500px" height="500px" />
    </div>
    <div class="instruction">It should look like this.</div>
    <div class="image">
        <img src="images/template/dl5.png" alt="Opened csv." width="700px" height="500px" />
    </div>
</div>
<div class="step extra" id="step4">
    <div class="step_title">Step 4: Copy Data into Template + Save</div>
    <div class="instruction">Click on cell A1, then click ctrl+A (or cmd+A for Mac Users)</div>
    <div class="image">
        <img src="images/template/dl6.png" alt="Selected csv." width="700px" height="500px" />
    </div>
    <div class="instruction">Switch to the template. Click on the "Paste Here" Cell, then click ctrl+V (or cmd+V for Mac users)</div>
    <div class="image">
        <img src="images/template/dl7.png" alt="Selected Paste Location." width="700px" height="500px" />
    </div>
</div>
<div class="step extra" id="step5">
    <div class="step_title">Enjoy!</div>
    <div class="instruction">And don't forget to save!</div>
    <div class="image">
        <img src="images/template/dl8.png" alt="Pasted Round Reports." width="700px" height="500px" />
    </div>
</div>
<div class="step_navBar">
    <div class="step_nav" id="step_forward">[Next]</div>
    <div class="step_nav" id="step_backward">[Prev]</div>
</div>

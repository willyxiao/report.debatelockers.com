<h1 class="center"><?= $type ?> </h1>

<div class="padding"></div>
<div class="center">
    <form id="search_terms" action="download_reports.php" method="POST">
        <input id="report_search" name="terms" type="text" autofocus="autofocus" placeholder="Quick Search"/>
        <?php 
            if($type === "Searched") 
            {
                $i = 0; 
                
                foreach($rounds as $round)
                {
                    print("<input type=\"hidden\" name=\"". $type . "[" . $i . "]\" value=\"" . $round["report_id"] . "\" />"); 
                    $i++; 
                }
            }
        ?>
    </form>
</div>
<div class="padding"></div>

<table class="table table-striped center">
<thead>
    <tr>
        <th>TEAM</th>
        <th>TOURNAMENT</th>
        <th>ROUND</th>
        <th>SIDE</th>
        <th>OPPONENT</th>
        <th>JUDGE</th>
        <th>RESULT</th>
        <th colspan="2">OPTIONS</th>
    <tr>
</thead>
<tbody>
    <?php

        $i = 0; 
        
        // iterates over all of the rounds
        foreach($rounds as $round)
        {
            // prints to the table
            print("<tr class=\"t_row\" id=\"row" . $i . "\"><td>" . $round["team"] . "</td><td>" . $round["tournament"] . "</td><td>" . $round["round_num"] . "</td><td>" . $round["report_side"] . "</td><td>" . $round["report_opp"] . "</td><td>" . $round["judge_last"] . "</td><td>" . $round["report_result"]);
            // prints option to view/edit the round
            print("</td><td><form action=\"report_action.php\" method=\"POST\"><input type=\"hidden\" name=\"round_v\" value=\"" . $round["report_id"] . "\"/><button class=\"basic\" type=\"submit\">[view/edit]</button></form></td>"); 
            // prints option to delete the round
            print("<td><form class=\"delete\" action=\"report_action.php\" method=\"POST\"><input type=\"hidden\" name=\"round_d\" value=\"" . $round["report_id"] . "\"/><button class=\"delete basic\" type=\"submit\">[del]</button></form> </td></tr>"); 
            
            $i++; 
        }
    
    ?>
</tbody>
</table>
<div class="padding"></div>
<div id="bottom_options">
    <div id="download_all" class="option">[Download]</div>
</div>
<script>
    // onready
    $(document).ready(function() {
        
        // on input into search field
        $('#report_search').keyup(function() {
            
            // gets the value of the search input
            var input = $('#report_search').val(); 
            
            // makes it upper case
            input = input.toUpperCase();
            
            // iterates over all of the rows
            $('.t_row').each(function(i, row) {
                
                // gets the html in each row
                var row_html = $(this).html(); 
                
                // if the input is in row_html
                if(row_html.indexOf(input) !== -1)
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

        // on clicking the download csv file
        $('#bottom_options').children('#download_all').click(function() 
        {
            // submit the form
            $('#search_terms').submit(); 
        }); 
    }); 
</script>

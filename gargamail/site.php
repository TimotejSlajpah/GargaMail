<?php 
    /*Začetek seje in dekleracija sejnih spremenljivk*/
    session_start();

    $imapserver = "imap.gmail.com";
    $email = $_SESSION["email"];
    $geslo = $_SESSION["geslo"];
    $smtpserver = "smtp.gmail.com";

    /*preprečitev obiska strani brez Logiranja*/
    if(empty($imapserver)){
        header("Location: sometingwong.php");
    }
    else if(empty($smtpserver)){
        header("Location: sometingwong.php");
    }
    if(empty($email)){
        header("Location: sometingwong.php");
    }
    if(empty($geslo)){
        header("Location: sometingwong.php");
    }

    $files = glob('uploads/*');
        foreach($files as $file){ 
            unlink($file); 
        }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GargaMail</title>
    <link rel="stylesheet" href="styles/website.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

    <script>
        const bodiesJS = [];
        const attachments = [];
        const sender = [];
        const zadeva = [];
        const datum = [];
        var counter= 0;
    </script>
    

    <script>
        /*Odpiranje diva*/
        function Open(id){
            var identificator = id;
            var w = window.innerWidth;
            if(attachments[id] != "0"){
                document.getElementById(identificator).innerHTML = '<div InboxJS><div><button class="goBack" onclick="Close(' + id + ')"><i class="fa fa-arrow-left" aria-hidden="true"></i></button> <button class="Reply" onclick="Reply(\''+ sender[identificator]+'\', \''+ zadeva[identificator]+'\')">Reply</button></div> <div class="seperate"><b>Sender: ' 
            + sender[identificator] +' ┃</b> Subject: '+ zadeva[identificator]+ '</div> ' 
            + '<div>' + bodiesJS[identificator] + '<br><a download="FILENAME.jpg" href="data:image/png;base64,' + attachments[identificator] + ' ">Download File</a> </div></div>';
            }
            else{
                document.getElementById(identificator).innerHTML = '<div InboxJS><div><button class="goBack" onclick="Close(' + id + ')"><i class="fa fa-arrow-left" aria-hidden="true"></i></button> <button class="Reply" onclick="Reply(\''+ sender[identificator]+'\', \''+ zadeva[identificator]+'\')">Reply</button></div> <div class="seperate"><b>Sender: ' 
            + sender[identificator] +' ┃</b> Subject: '+ zadeva[identificator]+ '</div> ' 
            + '<div>' + bodiesJS[identificator] + '</div></div>';
            }

            if(w<=430){
                document.getElementById(identificator).style.height = "82.5vh";
                document.getElementById(identificator).style.padding = "1em 0em 0.75em 0.5em";
                document.getElementById(identificator).style.flex = "";
                document.getElementById(identificator).style.cursor = "default";
            }

            else{
                document.getElementById(identificator).style.height = "84vh";
                document.getElementById(identificator).style.padding = "1em 0em 0.75em 0.5em";
                document.getElementById(identificator).style.flex = "";
                document.getElementById(identificator).style.cursor = "default";
            }
            document.getElementById('bar').style.display = "none";
            document.getElementById('PgP').style.display = "none";
            document.getElementById('PgN').style.display = "none";
            document.getElementById('logId').style.display = "none";

            for (let i = 1; i<bodiesJS.length; i++){
                if(i!=id){
                    document.getElementById(i).style.display = "none";
                }
            }

        }

        /*Zapiranje diva*/
        function Close(identificator){
            var idime = "ime" +identificator;
            var idzadeva = "zadeva" +identificator;
            var iddatum = "datum" +identificator;
            var w = window.innerWidth;
            document.getElementById(identificator).innerHTML = '<p class = "ime" id="ime'+identificator+'">'+ sender[identificator] +' </p> <p class="zadeva" id="zadeva'+identificator+'"> Subject: <spam class="SamoZadeva">'+ zadeva[identificator] +'</spam> </p><p class="datum" id="datum'+identificator+'">'+ datum[identificator]+ ' </p>';
            
            if(w<=430){
                document.getElementById(identificator).style.height = "6.15em";
                document.getElementById(identificator).style.cursor = "pointer";
                document.getElementById(identificator).style.padding = "0";
                document.getElementById(idime).style.padding = "1em 0.35em 1em 0.5em";
                document.getElementById(idzadeva).style.padding = "1em 0.5em 1em 0.5em";
            }

            else{
                document.getElementById(identificator).style.height = "3.4em";
                document.getElementById(identificator).style.cursor = "pointer";
                document.getElementById(identificator).style.padding = "0";
                document.getElementById(idime).style.padding = "1em 0.4em 1em 0.5em";
                document.getElementById(idzadeva).style.padding = "1em 0 1em 0.5em";
                document.getElementById(iddatum).style.padding = "1em 0.5em 1em 0";
            }
            document.getElementById('bar').style.display = "";
            document.getElementById('PgP').style.display = "";
            document.getElementById('PgN').style.display = "";
            document.getElementById('logId').style.display = "";
            ThisPage();
            
            /*Preprečevanje bubblinga*/
            if (!e) var e = window.event;
            e.cancelBubble = true;
            if (e.stopPropagation) e.stopPropagation();
        }

        /*Odpiranje okna za pošiljanje mailov ali odgovarjanje*/
        function Send(){
            var w = window.innerWidth;
            if(counter == 0)
            {
                document.getElementById("SndWindow").style.display = "";
                document.getElementById("SndWindow").innerHTML = '<div class="messages" id="message"> <form action="mailer.php" method="post" enctype="multipart/form-data"><br><input type="email" name="za" class="prejemnik" placeholder="Send to"><br><input type="email" name="CC" class="CarbonCopy" placeholder="CC"><br><input type="text" name="zadeva" class="subject" placeholder="Subject"><br><br><textarea name="tekst" class="textbody"></textarea><br> <input type="submit" class="posljiMail" value = "Send" id="mailerBtn"> <input type="file" name="datoteka" id="datoteka" class="file"></form></div>'
                document.getElementById("SndWindow").style.position = "absolute";
                document.getElementById("SndWindow").style.zIndex = "10";

                if(w<=430){
                    document.getElementById("SndWindow").style.top = "50vh";
                    document.getElementById("SndWindow").style.left = "2.5vw";
                }
                else{
                    document.getElementById("SndWindow").style.top = "49.2vh";
                    document.getElementById("SndWindow").style.left = "59.9vw";
                }
                document.getElementById("message").style.border = "0.2em solid black";
                counter=1;
            }
            /*zapiranje okna*/
            else{
                document.getElementById("SndWindow").style.display = "none";
                counter=0;
            }
            /*Preprečevanje bubblinga*/
            if (!e) var e = window.event;
            e.cancelBubble = true;
            if (e.stopPropagation) e.stopPropagation();
            
        }

        function Reply(respondee, zadevaRe){
            var w = window.innerWidth;
            if(counter == 0)
            {
                document.getElementById("SndWindow").style.display = "";
                document.getElementById("SndWindow").innerHTML = '<div class="messages" id="message"><form action="mailer.php" method="post" enctype="multipart/form-data"><br><input type="email" value="'+ respondee +'" name="za" class="prejemnik" placeholder="Send to"><br><input type="email" name="CC" class="CarbonCopy" placeholder="CC"><br><input type="text" value="Re: '+ zadevaRe +'" name="zadeva" class="subject" placeholder="Subject"><br><br><textarea name="tekst" class="textbody"></textarea><br> <input type="submit" class="posljiMail" value = "Send" id="mailerBtn"> <input type="file" name="datoteka" id="datoteka" class="file"></form></div>'
                document.getElementById("SndWindow").style.position = "absolute";
                document.getElementById("SndWindow").style.zIndex = "10";
                if(w<=430){
                    document.getElementById("SndWindow").style.top = "50vh";
                    document.getElementById("SndWindow").style.left = "2.5vw";
                }
                else{
                    document.getElementById("SndWindow").style.top = "49.7vh";
                    document.getElementById("SndWindow").style.left = "59.7vw";
                }
                document.getElementById("message").style.border = "0.2em solid black";
                counter=1;
            }
            /*zapiranje okna*/
            else{
                document.getElementById("SndWindow").style.display = "none";
                counter=0;
            }
            /*Preprečevanje bubblinga*/
            if (!e) var e = window.event;
            e.cancelBubble = true;
            if (e.stopPropagation) e.stopPropagation();
            
        }

        function NextPage(){
            selection-=10;
            for (var i = 1; i<=konstanta; i++){
                document.getElementById(i).style.display = "none";
            }
            if(selection<=0){
                if(konstanta%10 != 0){
                    selection = konstanta%10;
                }
                else{
                    selection = 10;
                }
            }
            if(selection%10 != 0){
                    if(selection<10){
                        for(var i = 0; i<selection; i++){
                            document.getElementById(selection-i).style.display = "flex";
                        }
                    }
                    else{
                        for(var i = 0; i<10; i++){
                            document.getElementById(selection-i).style.display = "flex";
                        }
                    }
            }
           
                else{
                    for(var i = 0; i<10; i++){
                    document.getElementById(selection-i).style.display = "flex";
                    }
                }
            console.log(selection);
        }

        function PreviousPage(){
            selection+=10;
            for (var i = 1; i<=konstanta; i++){
                document.getElementById(i).style.display = "none";
            }
                    if(selection>=konstanta){
                        selection=konstanta;
                        for(var i = 0; i<10; i++){
                            document.getElementById(selection-i).style.display = "flex";
                        }
                    }
                    else{
                        for(var i = 0; i<10; i++){
                            document.getElementById(selection-i).style.display = "flex";
                        }
                    }
            console.log(selection);
        }

        function ThisPage(){
            for (var i = 1; i<=konstanta; i++){
                document.getElementById(i).style.display = "none";
            }
            if(selection<=0){
                if(konstanta%10 != 0){
                    selection = konstanta%10;
                }
                else{
                    selection = 10;
                }
            }
            if(selection%10 != 0){
                    if(selection<10){
                        for(var i = 0; i<selection; i++){
                            document.getElementById(selection-i).style.display = "flex";
                        }
                    }
                    else{
                        for(var i = 0; i<10; i++){
                            document.getElementById(selection-i).style.display = "flex";
                        }
                    }
            }

            else if(selection>=konstanta){
                        selection=konstanta;
                        for(var i = 0; i<10; i++){
                            document.getElementById(selection-i).style.display = "flex";
                        }
                    }
           
                else{
                    for(var i = 0; i<10; i++){
                    document.getElementById(selection-i).style.display = "flex";
                    }
                }
        }
        

    </script>

    <div class="main">
        <div class="top">
            <div class="phone">
                <div class="profile" id="LOGO">
                    <picture>
                        <source media="(max-width: 650px)" srcset="gargasmall.svg">
                        <img src="gargamail.svg" alt="gargamail logo">
                    </picture>
                </div>
                <!-- Search bar -->
                <div class="search">
                    <input id="bar" type="text" placeholder="Search...">
                </div>
            </div>

            <div class="phone2">
                <!-- Gumb za odpiranje in zapiranje okna za pošiljanje mailov -->
                <div id="Gumbi">
                    <button class="Send" id="btnSend" onclick='Send()'>
                        <i class="fa fa-plus" aria-hidden="true"></i>
                    </button>
                    <!-- gumba za spreminjanje strani -->
                        <button class="PreviousPage" id="PgP" onclick="PreviousPage()"><i class="fa fa-chevron-left" aria-hidden="true"></i></button>
                        <button class="NextPage" id="PgN" onclick="NextPage()"><i class="fa fa-chevron-right" aria-hidden="true"></i></button>
                </div>

                <!-- gumb za LOGOUT -->
                <div class="logout">
                    <div id="SignedIn">Signed in with: <?php echo $email; ?></div>
                    <div><form action="logout.php">
                        <button type="submit" class="logoutBtn" id="logId"><i class="fa fa-sign-out" aria-hidden="true"></i></button>
                    </form></div>
                </div>
            </div>
        </div>

        <div class="bottom">
            <div class="inbox" id="inboxId">
            <?php
        ?>
        <div id="list" class="container">
        <?php
            /*imap povezava*/
            $conn = imap_open("{" . $imapserver . ":993/imap/ssl}INBOX", $email, $geslo) or die(header("Location: sometingwong.php"));
            $emails = imap_search($conn, "ALL");
            
            /*preverja ali je spremenljivka emails prazna */
            if (! empty($emails)) 
            {
                /*sortiranje mailov*/
                rsort($emails);
                ?>
                
            <?php
            /*id postane število mailov*/
            $id = imap_num_msg($conn);
            ?>
            <script>
                /*pretvarjanje id-ja iz php-ja v JS*/
                var st = <?php echo json_encode($id); ?>;
                var selection = <?php echo json_encode($id); ?>;
                var loopNr = <?php echo json_encode($id); ?>;
                const konstanta = <?php echo json_encode($id); ?>;
            </script>
            
            <?php
                /*sprehajanje čez tabelo emailov*/
                foreach ($emails as $emailId) 
                {
                    /*pridobimo overview mailov(pošiljatelj, zadeva)*/
                    $vse = imap_fetch_overview($conn, $emailId, 0);
                    /*pridobimo datum*/
                    $datum = date("d F, Y, h:i A", strtotime($vse[0]->date));
                    /*pridobimo vsebino maila*/
                    $body = quoted_printable_decode(imap_utf8(imap_fetchbody($conn, $id, 1)));
                    $attachment = "0";

                    if(imap_fetchmime($conn, $id, 2)){
                        $attachment = imap_fetchbody($conn, $id, 2);
                    }

            ?>
            
                    <script>
                        /*pretvarjanje iz PHP-ja v JS*/
                        bodiesJS[st] = <?php echo(json_encode($body));?>;
                        attachments[st] = <?php echo(json_encode($attachment));?>;
                        sender[st] = <?php echo(json_encode(imap_utf8($vse[0]->from)));  ?>;
                        zadeva[st] = <?php echo(json_encode(imap_utf8($vse[0]->subject)));  ?>;
                        datum[st] = <?php echo(json_encode(imap_utf8(date("d F, Y, h:i A", strtotime($vse[0]->date)))));  ?>;
                        st--;
                    </script>


            <?php
                    /*prvi izpis mailov in dodelitev id-jev*/
                    echo '<div class = "content" id="'.$id.'" onclick="Open(this.id)">';
                    echo '<p class = "ime" id="ime'.$id.'">'.imap_utf8($vse[0]->from);' </p>';
                    echo '<p class="zadeva" id="zadeva'.$id.'"> Subject: <spam class="SamoZadeva">'.imap_utf8($vse[0]->subject);'</spam> </p>';
                    echo '<p class="datum" id="datum'.$id.'">'.$datum;' </p>';
                    echo '</div>';
                    $id--;
                }
            }
            imap_close($conn);
            ?>
            <script>
                ThisPage();
            </script>
        </div>
            </div>
        </div>
        <div id="SndWindow">

        </div>
    </div>
    <!-- search-->
    <script src="index.js"></script>
</body>
</html>
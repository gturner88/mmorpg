<?php

	
	$pageLink = $_SERVER['PHP_SELF']; //current page
	$dateCreated = "6/21/2011"; //date created
	$title = "Message Center"; //title of document
	$isLoggedIn = true;
	
	include("includes/Header.php"); //includes header
    // Load the class
    require('includes/pm.php');
	define('MESSAGE_DELETE','1'); // How many month till a message is completly deleted
    // Set the userid to 2 for testing purposes... you should have your own usersystem, so this should contain the userid
    $userid=$stat[id];
    // initiate a new pm class
    $pm = new cpm($userid);
    
    // check if a new message had been send
    if(isset($_POST['newmessage'])) {
        // check if there is an error while sending the message (beware, the input hasn't been checked, you should never trust users input!)
        if($pm->sendmessage($_POST['to'],$_POST['subject'],$_OPOST['message'])) {
            // Tell the user it was successful
            $SUCCESS = "Message successfully sent!";
			include("includes/Error.php");
        } else {
            // Tell user something went wrong it the return was false
            $ERROR = "Error, couldn't send PM. Maybe wrong user.";
			include("includes/Error.php");
        }
    }
    
    // check if a message had been deleted
    if(isset($_POST['delete'])) {
        // check if there is an error during deletion of the message
        if($pm->deleted($_POST['did'])) {
            $SUCCESS = "Message successfully deleted!";
			include("includes/Error.php");
        } else {
            $ERROR = "Error, couldn't delete PM!";
			include("includes/Error.php");
        }
    }
    
?>
<?php
// In this switch we check what page has to be loaded, this way we just load the messages we want using numbers from 0 to 3 (0 is standart, so we don't need to type this)
if(isset($_GET['p'])) {
    switch($_GET['p']) {
        // get all new / unread messages
        case 'new': $pm->getmessages(); break;
        // get all send messages
        case 'send': $pm->getmessages(2); break;
        // get all read messages
        case 'read': $pm->getmessages(1); break;
        // get all deleted messages
        case 'deleted': $pm->getmessages(3); break;
        // get a specific message
        case 'view': $pm->getmessage($_GET['mid']); break;
        // get all new / unread messages
        default: $pm->getmessages(); break;
    }
} else {
    // get all new / unread messages
    $pm->getmessages();
}
// Standard links
?>
<style type="text/css">
	
	table.form { margin: 5px 0 0 29px; border-collapse: collapse; }
	table.form * { vertical-align: middle; }
	
	table.form th, table.form td { font: 12pt Georgia, "Times New Roman", Times, serif; padding: 4px 5px; text-align: left; font-weight: normal; }
	
	table.form th label, table.form td label { color: #181818; margin-right: 12px; }
	table.form td span { font-size: 0.9em; color: #181818; margin-left: 8px; }
	table.form td samp { font: 0.9em Verdana, Arial, Helvetica, sans-serif; color: #000000; }
	
	table.form input { width: 340px; }
	table.form input.antispam { width: 60px; }
	table.form textarea { width: 400px; height: 160px; }
	
	table.form textarea, table.form input.text-input
	{ border: 2px solid #838383; padding: 3px 2px; font: 12pt Georgia, "Times New Roman", Times, serif; }
	
	table.form input.antispam { border: 2px solid #838383; padding: 4px 2px; font: 12pt Verdana, Arial, Helvetica, sans-serif; }
	
	table.form th.message-up { vertical-align: top !important; }
	
	table.form th.invisible { visibility: hidden; }
	
	table.form td.submit-button-right { text-align: right !important; }
	table.form input.submit-text { font: 12pt Georgia, "Times New Roman", Times, serif; letter-spacing: 1px; width: auto; }
	
	.Message_Menu { vertical-align:top; border-right:2px solid #000;  }
	.Message_Menu a { text-decoration:none; }
	.Message_Title { text-align:center; font: 16pt "Times New Roman", Times, serif; font-weight:bold; color:#CCC; border-bottom:2px solid #000;  }
	.Message_Content { text-align:center; }
	.Message_Table { border:2px solid #000; }
</style>
<table class="Message_Table" width="750">
  <tr>
    <td colspan="2" class="Message_Title">Message Center</td>
  </tr>
  <tr>
    <td width="6" class="Message_Menu">
    <a href='<?php echo $_SERVER['PHP_SELF']; ?>?p=compose'>Compose&nbsp;Mail</a><br />
<a href='<?php echo $_SERVER['PHP_SELF']; ?>?p=new'>New&nbsp;Messages</a><br />
<a href='<?php echo $_SERVER['PHP_SELF']; ?>?p=send'>Sent&nbsp;Messages</a><br />
<a href='<?php echo $_SERVER['PHP_SELF']; ?>?p=read'>Read&nbsp;Messages</a><br />
<a href='<?php echo $_SERVER['PHP_SELF']; ?>?p=deleted'>Deleted&nbsp;Messages</a>
 </td>
    <td class="Message_Content" align="center"><div>
<?php
// if it's the standart startpage or the page new, then show all new messages
if(!isset($_POST['reply']) && $_GET['p'] == 'new' || !isset($_POST['new']) && $_GET['p'] == 'new') {
?>

<table border="0" cellspacing="1" cellpadding="1"  width="100%">
    <tr>
        <td>From</td>
        <td>Title</td>
        <td>Date</td>
    </tr>
    <?php
        // If there are messages, show them
        if(count($pm->messages)) {
            // message loop
            for($i=0;$i<count($pm->messages);$i++) {
                ?>
                <tr>
                    <td><?php echo $pm->messages[$i]['from']; ?></td>
                    <td><a href='<?php echo $_SERVER['PHP_SELF']; ?>?p=view&mid=<?php echo $pm->messages[$i]['id']; ?>'><?php echo $pm->messages[$i]['title'] ?></a></td>
                    <td><?php echo $pm->messages[$i]['created']; ?></td>
                </tr>
                <?php
            }
        } else {
            // else... tell the user that there are no new messages
            echo "<tr><td colspan='3'>"; $ERROR = "No new messages found!"; include("includes/Error.php"); echo "</td></tr>";
        }
    ?>
</table>

<?php
// check if the user wants send messages
} elseif($_GET['p'] == 'send') {
?>

<table border="0" cellspacing="1" cellpadding="1" width="100%">
    <tr>
        <td>To</td>
        <td>Title</td>
        <td>Status</td>
        <td>Date</td>
    </tr>
    <?php
        // if there are messages, show them
        if(count($pm->messages)) {
            // message loop
            for($i=0;$i<count($pm->messages);$i++) {
                ?>
                <tr>
                    <td><?php echo $pm->messages[$i]['to']; ?></td>
                    <td><a href='<?php echo $_SERVER['PHP_SELF']; ?>?p=view&mid=<?php echo $pm->messages[$i]['id']; ?>'><?php echo $pm->messages[$i]['title'] ?></a></td>
                    <td>
                    <?php  
                        // If a message is deleted and not viewed
                        if($pm->messages[$i]['to_deleted'] && !$pm->messages[$i]['to_viewed']) {
                            echo "Deleted without reading";
                        // if a message got deleted AND viewed
                        } elseif($pm->messages[$i]['to_deleted'] && $pm->messages[$i]['to_viewed']) {
                            echo "Deleted after reading";
                        // if a message got not deleted but viewed
                        } elseif(!$pm->messages[$i]['to_deleted'] && $pm->messages[$i]['to_viewed']) {
                            echo "Read";
                        } else {
                        // not viewed and not deleted
                            echo "Not read yet";
                        }
                    ?>
                    </td>
                    <td><?php echo $pm->messages[$i]['created']; ?></td>
                </tr>
                <?php
            }
        } else {
            // else... tell the user that there are no new messages
            echo "<tr><td colspan='4'>"; $ERROR = "No send messages found!"; include("includes/Error.php"); echo "</td></tr>";
        }
    ?>
</table>

<?php
// check if the user wants the read messages
} elseif($_GET['p'] == 'read') {
?>
    <table border="0" cellspacing="1" cellpadding="1" width="100%">
    <tr>
        <td>From</td>
        <td>Title</td>
        <td>Date</td>
    </tr>
    <?php
        // if there are messages, show them
        if(count($pm->messages)) {
            // message loop
            for($i=0;$i<count($pm->messages);$i++) {
                ?>
                <tr>
                    <td><?php echo $pm->messages[$i]['from']; ?></td>
                    <td><a href='<?php echo $_SERVER['PHP_SELF']; ?>?p=view&mid=<?php echo $pm->messages[$i]['id']; ?>'><?php echo $pm->messages[$i]['title'] ?></a></td>
                    <td><?php echo $pm->messages[$i]['to_vdate']; ?></td>
                </tr>
                <?php
            }
        } else {
            // else... tell the user that there are no new messages
            echo "<tr><td colspan='4'>"; $ERROR = "No read messages found!"; include("includes/Error.php"); echo "</td></tr>";
        }
    ?>
    </table>

<?php
// check if the user wants the deleted messages
} elseif($_GET['p'] == 'deleted') {
?>
    <table border="0" cellspacing="1" cellpadding="1" width="100%">
    <tr>
        <td>From</td>
        <td>Title</td>
        <td>Date</td>
    </tr>
    <?php
        // if there are messages, show them
        if(count($pm->messages)) {
            // message loop
            for($i=0;$i<count($pm->messages);$i++) {
                ?>
                <tr>
                    <td><?php echo $pm->messages[$i]['from']; ?></td>
                    <td><a href='<?php echo $_SERVER['PHP_SELF']; ?>?p=view&mid=<?php echo $pm->messages[$i]['id']; ?>'><?php echo $pm->messages[$i]['title'] ?></a></td>
                    <td><?php echo $pm->messages[$i]['to_ddate']; ?></td>
                </tr>
                <?php
            }
        } else {
            // else... tell the user that there are no new messages
            echo "<tr><td colspan='4'>"; $ERROR = "No deleted messages found!"; include("includes/Error.php"); echo "</td></tr>";
        }
    ?>
</table>
<?php
// if the user wants a detail view and the message id is set...
} elseif($_GET['p'] == 'view' && isset($_GET['mid'])) {
    // if the users id is the recipients id and the message hadn't been viewed yet
    if($userid == $pm->messages[0]['toid'] && !$pm->messages[0]['to_viewed']) {
        // set the messages flag to viewed
        $pm->viewed($pm->messages[0]['id']);
    }
?>
		<table class="form" cellpadding="2" cellspacing="2">

			<tr>
				<th style="border:2px inset #000; color:#333;"><strong>From:</strong></th>
				<td style="border:2px inset #000; color:#CCC;"><?php echo $pm->messages[0]['from']; ?></td>
			</tr>

			<tr>
				<th style="border:2px inset #000; color:#333;"><strong>Date:</strong></th>
				<td style="border:2px inset #000; color:#CCC;"><?php echo $pm->messages[0]['created']; ?></td>
			</tr>

			<tr class="final_input">
				<th style="border:2px inset #000; color:#333;"><strong>Subject:</strong></th>
				<td style="border:2px inset #000; color:#CCC;"><?php echo $pm->messages[0]['title']; ?></td>

			</tr>

			<tr>
				<th class="message-up" style="color:#333;">Message:</th>

				<td style="border:2px inset #000; color:#CCC;">
				<?php echo $pm->render($pm->messages[0]['message']); ?>
				</td>
			</tr>

			<tr>
				<td class="submit-button-right" colspan="2"><form name='reply' method='post' action='<?php echo $_SERVER['PHP_SELF']; ?>'>
        <input type='hidden' name='rfrom' value='<?php echo $pm->messages[0]['from']; ?>' />
        <input type='hidden' name='rsubject' value='Re: <?php echo $pm->messages[0]['title']; ?>' />
        <input type='hidden' name='rmessage' value='[quote]<?php echo $pm->messages[0]['message']; ?>[/quote]' />
        <input type='submit' name='reply' value='Reply' />
    </form>
    <form name='delete' method='post' action='<?php echo $_SERVER['PHP_SELF']; ?>'>
        <input type='hidden' name='did' value='<?php echo $pm->messages[0]['id']; ?>' />
        <input type='submit' name='delete' value='Delete' />
    </form></td>
			</tr>
		</table>
<?php
}
if(isset($_POST['reply']) || $_GET['p'] == "compose")
{
?>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
		<table class="form" cellpadding="2" cellspacing="2">

			<tr>
				<th><label for="to"><strong>To:</strong></label></th>
				<td><input name="to" id="to" type="text" size="30" class="text-input" value="<?php if(isset($_POST['reply'])) { echo $_POST['rfrom']; } ?>" /></td>
			</tr>

			<tr class="final_input">
				<th><label for="subject"><strong>Subject:</strong></label></th>
				<td><input name="subject" id="subject" type="text" size="30" class="text-input" value='<?php if(isset($_POST['reply'])) { echo $_POST['rsubject']; } ?>' /></td>

			</tr>

			<tr>
				<th class="message-up"><label for="message">Message:</label></th>

				<td>
				<textarea name="message" id="message" cols="30" rows="5"><?php if(isset($_POST['reply'])) { echo $_POST['rmessage']; } ?></textarea>
				</td>
			</tr>

			<tr>
				<td class="submit-button-right" colspan="2"><input class="submit-text" type="submit" name="newmessage" value="Send" alt="SEND" /></td>
			</tr>
		</table>
</form>

<?php } ?>

</div>
    </td>
  </tr>
</table>

<?php include("includes/Footer.php"); ?>
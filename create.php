<?php
session_start();
include 'functions.php';
$pdo = pdo_connect_mysql();
// Output message variable
$msg = '';
// Check if POST data exists (user submitted the form)
if (isset($_POST['title'], $_POST['msg'])) {
    // Validation checks... make sure the POST data is not empty
    if (empty($_POST['title']) ||  empty($_POST['msg'])) {
        $msg = 'Please complete the form!';
    }  
    {
        // Insert new record into the tickets table
        $stmt = $pdo->prepare('INSERT INTO tickets (user_id, title, msg) VALUES (?, ?, ?)');
        $stmt->execute([$_POST['user_id'], $_POST['title'], $_POST['msg'] ]);
        // Redirect to the view ticket page, the user will see their created ticket on this page
        header('Location: view.php?id=' . $pdo->lastInsertId());
    }
}
?>

<?=template_header('Create Ticket')?>

<h2>Hi, <?php echo htmlspecialchars($_SESSION['id']) ?></h2>

<div class="content create">
	<h2>Create Ticket</h2>
    <form action="create.php" method="post">
        <label for="title">Title</label>
        <input type="text" name="title" placeholder="Title" id="title" required>
        <input type='hidden' name='user_id' value='<?php echo htmlspecialchars($_SESSION['id']) ?> '>
        <label for="ticket_type">Choose a Ticket Type:</label>
        <select name="ticket_type" id="ticket_type">
            <option value="development">Development</option>
            <option value="testing">Testing</option>
            <option value="production">Production</option>
        </select>
        <label for="msg">Description</label>
        <textarea name="msg" placeholder="Enter your description here..." id="msg" required></textarea>
        <label for="priority">Set the Ticket Priority:</label>
        <select name="priority" id="priority">
            <option value="low">Low</option>
            <option value="medium">Medium</option>
            <option value="high">High</option>
        </select> 
        <input type="submit" value="Create">         
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>

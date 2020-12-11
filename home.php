<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: index.html');
	exit;
}

include 'functions.php';
// Connect to MySQL using the below function
$pdo = pdo_connect_mysql();
// MySQL query that retrieves  all the tickets from the databse
$stmt = $pdo->prepare('SELECT * FROM tickets ORDER BY created DESC');
$stmt->execute();
$tickets = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?=template_header('Tickets')?>

<div class="content home">

	<h2>Tickets</h2>
    <p>Welcome <b><?php echo htmlspecialchars($_SESSION['name'])?></b> to the ticketing system, you can view the list of tickets below.</p>

	<div class="btns">
		<a href="create.php" class="btn">Create Ticket</a>
	</div>


	<div class="tickets-list">
		<?php foreach ($tickets as $ticket): ?>
		<a href="view.php?id=<?=$ticket['id']?>" class="ticket">
			<span class="con">
				<?php if ($ticket['status'] == 'open'): ?>
				<i class="far fa-clock fa-2x"></i>
				<?php elseif ($ticket['status'] == 'resolved'): ?>
				<i class="fas fa-check fa-2x"></i>
				<?php elseif ($ticket['status'] == 'closed'): ?>
				<i class="fas fa-times fa-2x"></i>
				<?php endif; ?>
                <span class="id"><?=htmlspecialchars($ticket['id'], ENT_QUOTES)?></span>
			</span>
                
				<span class="id"><?=htmlspecialchars($ticket['title'], ENT_QUOTES)?></span>
                <span class="id"><?=htmlspecialchars($ticket['ticket_type'], ENT_QUOTES)?></span>
                <span class="id"><?=htmlspecialchars($ticket['priority'], ENT_QUOTES)?></span>
			<span class="con created"><?=date('F dS, G:ia', strtotime($ticket['created']))?></span>
		</a>
		<?php endforeach; ?>
	</div>
</div>

<?=template_footer()?>
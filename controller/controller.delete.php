<?php
if( isset( $_SESSION['userId'] ) )
{
	if( isset( $_GET['id'] ) && is_numeric( $_GET['id'] ) )
	{
		require_once( 'model/model.task.php' );
		require_once( 'model/model.todo.php' );
		$task = new Task( $db );
		$todo = new Todo( $db );
		
		$result = $task->getTaskById( $_GET['id'] );
		if( !$result ) {
			sendMessage( 'Impossible de trouvé la tâche', 'error' );
		} else if( !$todo->getTodoByIdAndUserId( $result->todo_id, $_SESSION['userId'] ) ) {
			sendMessage( "Vous n'avez pas accès à cette tâche", "error" );
		}
		else
		{
			if( $task->removeTaskById( $_GET['id'] ) ) {
				sendMessage( 'La tâche à bien été supprimé', 'valid' );
			} else {
				sendMessage( 'Une erreur s\'est produite', 'error' );
			}
		}
	}	
}
else header( 'Location: /connect' );
?>
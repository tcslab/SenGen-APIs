<?php
$subject = "SYNDESI Connection failed";

				$headers   = array();
				$headers[] = "MIME-Version: 1.0";
				$headers[] = "Content-type: text/plain; charset=iso-8859-1";
				$headers[] = "From: marios.karagiannis@unige.ch";
				$headers[] = "Reply-To: marios.karagiannis@unige.ch";
				$headers[] = "X-Mailer: PHP/".phpversion();

				$to = "Stephane.Kundig@unige.ch";
				
				$message = "It looks like Syndesi server is down!";
				$header = implode("\r\n", $headers);
				
				mail($to, $subject, $message, $header);
			
?>
<?php

// Function to read user input from terminal
function readTerminalInput()
{
    $stdin = fopen('php://stdin', 'r');
    $input = trim(fgets($stdin));
    fclose($stdin);
    return $input;
}

echo "Enter your message (Press Enter on an empty line to save and exit):\n";

while (true) {
    $message = '';
    // Keep reading input until the user presses Enter on an empty line
    while (true) {
        // Read the input from the user
        $input = readTerminalInput();

        // If the user pressed Enter on an empty line, save the message to 'message.txt' and exit
        if (empty($input)) {
            // Save the message to 'message.txt'
            file_put_contents('client.txt', $message);

            //echo "Message saved to 'client.txt'. Exiting...\n";
            break;
        }

        // Append the input to the message variable
        $message .= $input . PHP_EOL;
    }
}

<?php
//==============Adding the message============
function addMessage($name,$email,$message)
{
    //first read the message array and make it a array
    $myfile1 = fopen("./assets/messages.txt", "r") or die("Unable to open file!");

    if ( 0 == filesize("./assets/messages.txt") )
    {
        // echo "file empty";
        $messagesArray = array();
    }
    else
    {
        $messages =  fread($myfile1,filesize("./assets/messages.txt"));
        $messagesArray = json_decode($messages,true);
        // print_r($messagesArray);
        fclose($myfile1);
    }
    //append the mesage to the array 
    $messagesToStore = array(
                        'message'=>$message,
                        'date' => date('Y-M-D hh:mm:s'),
                        'email' => $email,
                        'name' => $name
    );
    array_push($messagesArray,$messagesToStore);
    //save the updated array
    $myfile = fopen("./assets/messages.txt", "w") or die("Opps. Something Went Wrong!Unable to open file!");
    fwrite($myfile, json_encode($messagesArray));
    fclose($myfile);
    
    return true;

}

function readMessages()
{
    //first read the message array and make it a array
    $myfile = fopen("./assets/messages.txt", "r") or die("Unable to open file!");

    if ( 0 == filesize("./assets/messages.txt") )
    {
        echo "No messagegs";
    }
    else
    {
        $messages =  fread($myfile,filesize("./assets/messages.txt"));
        $messagesArray = json_decode($messages,true);
        // print_r($messagesArray);
        fclose($myfile);
        return $messagesArray;
    }
}

function deleteMessages($messageIndex)
{
    //read the file
    $myfile = fopen("./assets/messages.txt", "r") or die("Unable to open file!");
    $messages =  fread($myfile,filesize("./assets/messages.txt"));
    $messagesArray = json_decode($messages,true);
    unset($messagesArray[$messageIndex]);

    $myfile = fopen("./assets/messages.txt", "w") or die("Unable to open file!");
    fwrite($myfile, json_encode($messagesArray));
    fclose($myfile);
    
    
}

// addMessage();
// readMessages();
// deleteMessages(0);

if(isset($_POST["addMessage"]))
{
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    $response = addMessage($name,$email,$message);
    if($response)
    {
        echo json_encode(['status'=>'true','message'=>'Message sent successfully']);
    }
    else 
    {
        echo json_encode(['status'=>'false','message'=>'Something went wrong']);
    }
}
else if(isset($_POST['readMessage']))
{
    echo json_encode(readMessages());

}

else if(isset($_POST['deleteMessage'])) 
{
    echo "delete messages";

}
else
{
    echo "no proper request";
}



?>

<?php
include("dbconnection.php");
$conn->set_charset("utf8");

$tables = array();
$sql = "SHOW TABLES";
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_row($result)) {
    $tables[] = $row[0];
}
$sqlScript = "";
foreach ($tables as $table) {
        // Prepare SQLscript for creating table structure
    $query = "SHOW CREATE TABLE $table";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_row($result);
    $sqlScript .= "\n\n" . $row[1] . ";\n\n";
    $query = "SELECT * FROM $table";
    $result = mysqli_query($conn, $query);
    $columnCount = mysqli_num_fields($result);
    // Prepare SQLscript for dumping data for each table
    for ($i = 0; $i < $columnCount; $i ++) {
        while ($row = mysqli_fetch_row($result)) {
            $sqlScript .= "INSERT INTO $table VALUES(";
            for ($j = 0; $j < $columnCount; $j ++) {
                $row[$j] = $row[$j];
             if (isset($row[$j])) {
                    $sqlScript .= '"' . $row[$j] . '"';
                } else {
                    $sqlScript .= '""';
                }
                if ($j < ($columnCount - 1)) {
                    $sqlScript .= ',';
                }
            }
            $sqlScript .= ");\n";
        }
    }
    
    $sqlScript .= "\n"; 
}

if(!empty($sqlScript))
{
    // Save the SQL script to a backup file
    $backup_file_name = DBUSER . '_backup_' . time() . '.sql';
    $fileHandler = fopen($backup_file_name, 'w+');
    
    $number_of_lines = fwrite($fileHandler, $sqlScript);
    fclose($fileHandler); 
    

 // Download the SQL backup file to the browser
    // header('Content-Description: File Transfer');
    // header('Content-Type: application/octet-stream');
    // header('Content-Disposition: attachment; filename=' . basename($backup_file_name));
    // header('Content-Transfer-Encoding: binary');
    // header('Expires: 0');
    // header('Cache-Control: must-revalidate');
    // header('Pragma: public');
    // header('Content-Length: ' . filesize($backup_file_name));
    // ob_clean();
    // flush();
    // readfile($backup_file_name);
    // exec('rm ' . $backup_file_name);
  

}
$backupfile=$backup_file_name;
$archive_file_name=rand().'icon.zip'; 
 $zip = new ZipArchive();
    $zip->open($archive_file_name, ZipArchive::CREATE );
    $zip->addFile($backupfile);
    $zip->close();
    
    // header("Content-type: application/zip"); 
    // header("Content-Disposition: attachment; filename=$archive_file_name"); 
    // header("Pragma: no-cache"); 
    // header("Expires: 0"); 
    // readfile("$archive_file_name");
    emailsend($archive_file_name); 

    unlink($archive_file_name);



function emailsend($backfile)
{

   
$to = 'shehryar.devp@gmail.com'; 
// Sender 
$from = 'sender@example.com'; 
$fromName = 'Admin'; 
 
// Email subject 
$subject = 'Database Backup';  
 
// Attachment file 
$file = $backfile; 
 
// Email body content 
$htmlContent = ' 
    <h3>Database Backup</h3> 
    <p>This email is sent from user to Admin.</p> 
'; 
 
// Header for sender info 
$headers = "From: $fromName"." <".$from.">"; 
 
// Boundary  
$semi_rand = md5(time());  
$mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";  
 
// Headers for attachment  
$headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\""; 
 
// Multipart boundary  
$message = "--{$mime_boundary}\n" . "Content-Type: text/html; charset=\"UTF-8\"\n" . 
"Content-Transfer-Encoding: 7bit\n\n" . $htmlContent . "\n\n";  
 
// Preparing attachment 
if(!empty($file) > 0){ 
    if(is_file($file)){ 
        $message .= "--{$mime_boundary}\n"; 
        $fp =    @fopen($file,"rb"); 
        $data =  @fread($fp,filesize($file)); 
 
        @fclose($fp); 
        $data = chunk_split(base64_encode($data)); 
        $message .= "Content-Type: application/octet-stream; name=\"".basename($file)."\"\n" .  
        "Content-Description: ".basename($file)."\n" . 
        "Content-Disposition: attachment;\n" . " filename=\"".basename($file)."\"; size=".filesize($file).";\n" .  
        "Content-Transfer-Encoding: base64\n\n" . $data . "\n\n"; 
    } 
} 
$message .= "--{$mime_boundary}--"; 
$returnpath = "-f" . $from; 
 
// Send email 
$mail = mail($to, $subject, $message, $headers, $returnpath);  
 
// Email sending status 
if($mail)
{
   echo json_encode(array("status"=>520));
}
else
{
    echo json_encode(array("status"=>590));

}
}




?>
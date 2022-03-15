<?php

class csvPreparer 
{
    protected $csv;
    protected $delimiter;
    
    /**
     * csvPreparer constructor
     * 
     * @param string $csv URL or directory of CSV
     * @param string $delimiter Character used for separating values in CSV, e.g., ',', '|'
     */
    function __construct($csv, $delimiter) 
    {
        $this->csv = $csv;
        $this->delimiter = $delimiter;
    }
    
    /**
     * If unable to open CSV send error email to admins, terminate
     * 
     * @return void
     */
    protected function mailError() 
    {
        if ($handle_test = fopen($this->csv, "r") == false) {
            $file_error = 'mail_error.html';
            $err_msg = "An error occurred while trying to open file: " . $this->csv;
            file_put_contents($file_error, $err_msg);
            include 'mail_error.php';
            exit();
        }	
    }

    protected function csvToArray() 
    {
        $this->mailError();
        $header = NULL;
        $data = array();
        if (($handle = fopen($this->csv, 'r')) !== false)
        {
            while (($row = fgetcsv($handle, 0, $this->delimiter)) !== false)
            {
                if(!$header)
                    $header = $row;
                else
                    $data[$row[0]] = array_combine($header, $row);
            }
            fclose($handle);
        }
        return $data;
    }	

    public function getArray() 
    {
        return $this->csvToArray();
    }
}
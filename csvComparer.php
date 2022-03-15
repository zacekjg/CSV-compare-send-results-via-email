<?php

class csvComparer 
{
    protected $yday_array = [];
    protected $tday_array = [];
    protected $tags = [];
    protected $csv_new_name;
    protected $csv_del_name;
    protected $status_name;

    /**
     * csvComparer constructor.
     * 
     * @param string $yday_array Array of records from previous day
     * @param string $tday_array Array of records from current day
     * @param array $tags Array of keys associated with records' data, **Keys must be same in $yday_array and $tday_array**
     * @param string $csv_new_name Name of CSV file containing records that had their status changed to active
     * @param string $csv_del_name Name of CSV file containing records that had their status changed to inactive
     * @param string $status_name Value that is set for active records 
     */
    function __construct(array $yday_array, array $tday_array, array $tags, $csv_new_name, $csv_del_name, $status_name) 
    {
        $this->yday_array = $yday_array;
        $this->tday_array = $tday_array;
        $this->tags = $tags;
        $this->csv_new_name = $csv_new_name;
        $this->csv_del_name = $csv_del_name;
        $this->status_name = $status_name;
        $this->csvMake();
    }

    /**
     * Create CSV files that are going to be emailed as attachments
     * 
     * @return void
     */
    protected function csvMake()
    {
        $csv_new = fopen (__DIR__ . '/csv' . '/' . $this->csv_new_name . '.csv', 'w+');
        $csv_del = fopen (__DIR__ . '/csv' . '/' . $this->csv_del_name . '.csv', 'w+');

        $header = array ('header1',
                        'header2', 
                        'header3', 
                        'header4', 
                        'header5', 
                        );
        
        fprintf($csv_new, chr(0xEF).chr(0xBB).chr(0xBF)); //UTF-8 coding
        fputcsv($csv_new, $header, ";");
        
        fprintf($csv_del, chr(0xEF).chr(0xBB).chr(0xBF)); 
        fputcsv($csv_del, $header, ";");
    }

    /**
     * Compare arrays, put differences in respective CSV files, return array of differences
     * 
     * @return array
     */
    protected function compare() 
    {
        $csv_new = fopen (__DIR__ . '/csv' . '/' . $this->csv_new_name . '.csv', 'a+');
        $csv_del = fopen (__DIR__ . '/csv' . '/' . $this->csv_del_name . '.csv', 'a+');
        $indexes = array_keys($this->yday_array);

        $i = 0;
        while (array_key_exists($i, $indexes)) {
            if ($this->yday_array[$indexes[$i]][$this->tags[0]] != $this->tday_array[$indexes[$i]][$this->tags[0]]) {
                if ($this->tday_array[$indexes[$i]][$this->tags[0]] == $this->status_name ) { 
                $put_csv_new = [
                                    $this->tday_array[$indexes[$i]][$this->tags[1]], 
                                    $this->tday_array[$indexes[$i]][$this->tags[2]], 
                                    $this->tday_array[$indexes[$i]][$this->tags[0]], 
                                    $this->tday_array[$indexes[$i]][$this->tags[3]], 
                                    $this->tday_array[$indexes[$i]][$this->tags[4]], 
                                ];
                fputcsv($csv_new, $put_csv_new, ";");
                } else {
                $put_csv_del = [
                                    $this->tday_array[$indexes[$i]][$this->tags[1]], 
                                    $this->tday_array[$indexes[$i]][$this->tags[2]], 
                                    $this->tday_array[$indexes[$i]][$this->tags[0]], 
                                    $this->tday_array[$indexes[$i]][$this->tags[3]], 
                                    $this->tday_array[$indexes[$i]][$this->tags[4]], 
                                ];
                fputcsv($csv_del, $put_csv_del, ";");
                }
            $print_diff[] = [
                                $this->tags[1] => $this->tday_array[$indexes[$i]][$this->tags[1]], 
                                $this->tags[2] => $this->tday_array[$indexes[$i]][$this->tags[2]], 
                                $this->tags[0] => $this->tday_array[$indexes[$i]][$this->tags[0]], 
                                "old_status" => $this->yday_array[$indexes[$i]][$this->tags[0]]
                            ];
        }
        $i++;
        } 
        return $print_diff;   
    }
    
    public function getComparisonResults() 
    {
        return $this->compare();
    }

    /**
     * Put new and active records to CSV, return array
     * 
     * @return array
     */
    protected function writeActiveNew() 
    {
        $csv_new = fopen (__DIR__ . '/csv' . '/' . $this->csv_new_name . '.csv', 'a+');
       
        $new = array_diff_key($this->tday_array, $this->yday_array);
        foreach ($new as $new_entity) {
            if ($new_entity[$this->tags[0]] == $this->status_name) {
                    $print_new[] = [
                                        $this->tags[1] => $new_entity[$this->tags[1]], 
                                        $this->tags[2] => $new_entity[$this->tags[2]], 
                                        $this->tags[0] => $new_entity[$this->tags[0]]
                                    ];

                    $put_csv_new = [
                                        $new_entity[$this->tags[1]], 
                                        $new_entity[$this->tags[2]], 
                                        $new_entity[$this->tags[0]], 
                                        $new_entity[$this->tags[3]], 
                                        $new_entity[$this->tags[4]], 
                        ];
                    fputcsv($csv_new, $put_csv_new, ";");
                }
        }
        return $print_new;
    }

    public function getActiveNew() 
    {
        return $this->writeActiveNew();
    }

    public function getTags()
    {
        return $this->tags;
    }
    
    public function getCSVNewName()
    {
        return $this->csv_new_name;
    }
    
    public function getCSVDelName()
    {
        return $this->csv_del_name;
    }

     /**
     * Create an array of differences formatted for easy addition to database
     * 
     * @return array
     */
    protected function makeDBArray() 
    {
        $DBArray = array();
        foreach ($this->compare() as $result) {
            $DBArray[] = array_values($result);
        }
        return $DBArray;
    }

    public function getArrayForDB() 
    {
        return $this->makeDBArray();
    }
    
}  
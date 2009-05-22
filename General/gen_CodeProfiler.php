<?

class CodeProfiler
{
    // constants
    // declare all the operations you want to keep track of here
    const OP_CONTROLLER_LOAD_DATA = 0;
    const OP_CONTROLLER_PROCESS_DATA = 1;
    const OP_GENERATEPDF = 2;
    const OP_STAFFPDF = 3;
    const OP_WRITETRANSACTIONS = 4;
    const OP_CONTROLLER_PREPARE_DISPLAY_DATA = 5;
    const OP_LOADBYRENID = 6;
    const OP_GETHRDBNSSRENLIST = 7;
    const OP_MERGEGETTHTML = 8;
    const OP_GETACCESSLIST = 9;
    const OP_GETHRDBREN = 10;
    const OP_GETHRDBREGION = 11;
    const OP_GETHRDBACESS = 12;
    const OP_ACCESSGETXML = 13;
    
    // MAKE SURE TO UPDATE THE NUMBER and the name array
    const TOTAL_NUM_OPS = 14;
    
    // variables
    protected $nameArray;
    protected $stackArray; // 2D array, 2nd Dimension is a stack
    protected $numCallsArray;
    protected $totalTimeArray;

    function __construct()
    {
        // echo 'Creating new Code Profiler<br/>';
        // init the arrays
        $this->nameArray = array('Controller LoadData()','Controller ProcessData()', 'Generating PDF', 'Generating PDF 1 Staff', 'Writing Transactions to DB', 'generating html', 'load by renID', 'getHrdbNssrenList', 'mergeAccounts getHTML', 'AccessRenList getDropList', 'getHRDBRen', 'getHRDBRegion', 'getHRDBAccess', 'access getXML');
        $this->stackArray = array();
        $this->numCallsArray = array();
        $this->totalTimeArray = array();
        
        for($i=0; $i < CodeProfiler::TOTAL_NUM_OPS; $i++)
        {
            $this->stackArray[$i] = array();
            $this->numCallsArray[$i] = 0;
            $this->totalTimeArray[$i] = 0;
        }
    }
    
    function start( $opID )
    {
        $this->numCallsArray[$opID]++;
        
        // $begTime = $this->micro_time();
        // echo 'The begTime is ['.$begTime.']<br/>';
        
        array_push( $this->stackArray[$opID], $this->micro_time() );
    }
    
    function end( $opID )
    {
        $startTime = array_pop ( $this->stackArray[$opID] );
        // echo 'The startTime is ['.$startTime.']<br/>';
        
        $endTime = $this->micro_time();
        // echo 'The endTime is ['.$endTime.']<br/>';
        
        $totalTime = round( ($endTime-$startTime), 6);
        // echo 'The totalTime is ['.$totalTime.']<br/>';
        
        $this->totalTimeArray[$opID] = round( ( $totalTime + $this->totalTimeArray[$opID] ), 6 );
        // echo 'The newValue is ['.$this->totalTimeArray[$opID].']<br/>';
    }
    
    // from php site
    function micro_time() 
    {
        $time = explode(' ', microtime());
        $time = $time[1] + $time[0];
        return $time;
    }
    
    function printOutput()
    {
        $output = '<table>';
        
        // print the headers
        $output .= '<tr><td><b>Name</b></td><td><b>Num Calls</b></td><td><b>Total Time</b></td><td><b>Avg Time</b></td></tr>';
        // for all ops
        for($i=0; $i < CodeProfiler::TOTAL_NUM_OPS; $i++)
        {
            // print name
            $name = $this->nameArray[$i];
            
            // print numCalls
            $numCalls = $this->numCallsArray[$i];
            
            // print totalTime
            $totalTime = $this->totalTimeArray[$i];
            
            // print averageTime
            $avgTime = 0;
            if ( $numCalls != 0 )
            {
                $avgTime = round ( ( $totalTime / $numCalls ), 4 );
            }
            
            $output .= '<tr><td>'.$name.'</td><td>'.$numCalls.'</td><td>'.round($totalTime,2).'</td><td>'.$avgTime.'</td></tr>';
            
        }
        
        $output .= '</table>';
        
        return $output;
            
    }

}

?>
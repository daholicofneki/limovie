<?php
/**
 * Database Class
 */

class Database {

    private $host;
    private $username;
    private $password;
    private $db;
    private $connection;
    private $arr            = array ();

    /**
     * Constructor
     *
     * @access      public
     * @return      void
     */
    public function __construct (Array $config = array() )
    {
        $this->host       = $config['host'];
        $this->username   = $config['username'];
        $this->password   = $config['password'];
        $this->db         = $config['database'];
        
        $this->connection = @mysql_pconnect ($this->host, $this->username, $this->password);
        
        try
        {
            if ( ! $this->connection)
            {
                throw new Exception ('Connection Error');
            }
            else
            {
                try
                {
                    if ( ! @mysql_select_db($this->db, $this->connection))
                    {
                        throw new Exception ('Connection Error'); 
                    }
                }
                catch (Exception $m)
                {
                    echo " Error : ". $m->getMessage ();
                }
            }
        }
        catch ( Exception $m)
        {
            echo " Error : ". $m->getMessage ();
        }
            
    }
    
    /**
     * Database Query
     *
     * @access      public
     * @param       string
     * @return      void
     */
    public function query ( $SQL = FALSE )
    {
        if ($SQL)
        {
            try
            {
                return mysql_query ($SQL);
            }
            catch ( Exception $m)
            {
                echo " Error : ". $m->getMessage ();
            }
        }
    }
    
    /**
     * Get All Record
     *
     * @access      public
     * @param       string
     * @return      void
     */
    public function get ( $SQL = FALSE , $tipe = 'all')
    {
        if ($SQL)
        {
            $SQL = $this->query ($SQL);
            if ( $SQL AND  mysql_num_rows($SQL) > 0 )
            {
                if ($tipe === 'all')
                {
                    while ($row = mysql_fetch_object ($SQL))
                    {
                        $this->arr[] = $row;
                    }
                    return $this->arr;
                }
                else
                {
                    return mysql_fetch_object ($SQL);
                }
            }
        }
    }
}

$DB1 = new Database (array(
    'host'          => 'localhost',
    'username'      => 'root',
    'password'      => '',
    'database'      => 'wordpress'
));


$DB2 = new Database (array(
    'host'          => 'localhost',
    'username'      => 'root',
    'password'      => '',
    'database'      => 'wordpress2'
));

/*  End class Database  */

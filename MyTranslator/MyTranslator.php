<?php

/**
* @author JakubD <jakubd@allstar.cz>
* 
* editovano zvenci - primo do masteru
* editovano na locale - do masteru
*/


Class MyTranslator
{
    
    public  $translations = array();
    
    private $languageCode;
    
    private $fileHandle;
    
    public  $translateFilepath;
    
    
    
    public function __construct($translateFilepath)
    {            
        if(!file_exists($translateFilepath))
            Throw new Exception("Path translateFilepath does not exists at $translateFilepath");
        
        $this->translateFilepath = $translateFilepath;
    }
    
    
    /**
    * Sets language to which will be translations made
    * 
    * @param string $languageCode
    */
    public function setLanguage($languageCode)
    {
        if(!is_string($languageCode))
            die("MyTranslator::setLanguage expects string.");
            
        $this->languageCode = $languageCode;
    }
    
    
    public function init()
    {        
        if(empty($this->languageCode))
            die('Error. Language Code not set. Use setLanguage($languageCode) first!');
        
        $this->openFile();
        $this->readData();
        
        fClose($this->fileHandle);            
    }
    
    
    public function openFile($filename = null, $mode = 'r')
    {
        if($filename === null)
            $filename = $this->translateFilepath . $this->languageCode . '.trs';
        
        $this->fileHandle = fOpen($filename, $mode);
        if(!$this->fileHandle)
            Throw new Exception("Can not open/create translator file @ $filename");
    }
    
    
    public function closeFile($handle = null)
    {
        if(!$handle)
            $handle = $this->fileHandle;
        fClose($handle);
    }
    
    
    public function readData()
    {
        $data = fRead($this->fileHandle, 99999);
        $this->translations = json_decode($data);
    }
    
    
    /**
    * Encodes translations to json and writes to translation file
    * 
    * @param array $data 
    */
    public function writeData($data)
    {

        $data = json_encode($data);
        if(!fWrite($this->fileHandle, $data))
            Throw new Exception('Can´t write to file :( Check permissions.');
    }
    
    
    /**
    * load self staticaly
    */
    public static function load()
    {
        return \Nette\Environment::getService('translator');
    }
    
      
     /**
     * Macro function. Used at templates.
     * Not actually used for direct translations! See method translate
     * 
     * @example somestring|__ 
     * @param string text to translate
     * @return string translated text
     */
    public static function __($string)
    {
        $Translator = self::load();
        
        if(isset($Translator->translations->$string))
            return $Translator->translations->$string;
        else
            return $string;
    }

    public function ___($string)
    {
        if(isset($this->translations->$string))
            return $this->translations->$string;
        else
            return $string;
    }

    

    
    
}

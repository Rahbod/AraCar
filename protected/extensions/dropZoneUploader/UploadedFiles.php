<?php
class UploadedFiles
{
    private $_path;
    private $_pathUrl;
    private $_storedFiles = [];


    public function __construct($path, $files = false)
    {
        $this->setPath($path);
        if($files)
            $this->addFiles($files);
    }

    /**
     * set upload path directory
     *
     * @param $path
     */
    public function setPath($path)
    {
        $this->_path = Yii::getPathOfAlias('webroot') . DIRECTORY_SEPARATOR . $path . DIRECTORY_SEPARATOR;
        $this->_pathUrl = Yii::app()->getBaseUrl(true) . '/' . $path . '/';

        if(!is_dir($this->_path))
            mkdir($this->_path, 0777, true);
    }

    /**
     * @return string path
     */
    public function getPath()
    {
        return $this->_path;
    }

    /**
     * Returns path directory's url
     * @return string url
     */
    public function getBaseUrl()
    {
        return $this->_pathUrl;
    }

    /**
     * Add Uploaded File Structure to stored files array
     *
     * @param string $filename without base path
     * @param bool|string $filePath if don't use from base path
     */
    public function add($filename, $filePath = false)
    {
        $path = $this->_path;
        $url = $this->_pathUrl;
        if($filePath){
            $path = $this->normalizePath($filePath);
            $url = $this->normalizeUrl($filePath);
        }
        if((string)$filename && file_exists($path . $filename))
            $this->_storedFiles[] = [
                'name' => $filename,
                'src' => $url . $filename,
                'size' => filesize($path . $filename),
                'serverName' => $filename,
            ];
    }

    /**
     * @param $filename
     * @param bool $deleteFile
     * @return bool
     */
    public function remove($filename, $deleteFile = false)
    {
        $fl = false;
        $sf = $this->getFiles();
        if($sf)
            foreach($sf as $k => $f)
                if($f && isset($f['serverName']) && $f['serverName'] == $filename){
                    if($deleteFile) @unlink($this->_path . $filename);
                    unset($this->_storedFiles[$k]);
                    $fl = true;
                }
        return $fl;
    }

    public function removeAll($deleteFile = false)
    {
        $fl = false;
        $sf = $this->getFiles();
        if($sf)
            foreach($sf as $k => $f)
                if($f && isset($f['serverName']) && file_exists($this->_path . $f['serverName'])){
                    $filename = $f['serverName'];
                    if($deleteFile) @unlink($this->_path . $filename);
                    unset($this->_storedFiles[$k]);
                    $fl = true;
                }
        return $fl;
    }

    /**
     * @param $filename
     * @return bool|int false if not exists and index of files array if exists
     */
    public function exists($filename)
    {
        $fl = false;
        $sf = $this->getFiles();
        if($sf)
            foreach($sf as $k => $f)
                if($f && isset($f['serverName']) && $f['serverName'] == $filename)
                    $fl = $k;
        return $fl;
    }

    /**
     * Replace old file in stored array with new filename
     *
     * @param string $oldFilename
     * @param string $newFilename
     * @param bool $deleteFile
     */
    public function replace($oldFilename, $newFilename, $deleteFile = true)
    {
        $this->remove($oldFilename, $deleteFile);
        $this->add($newFilename);
    }

    /**
     * Update files List
     *
     * @param $oldFilename
     * @param $newFilename
     * @param $newFilePath
     */
    public function update($oldFilename, $newFilename, $newFilePath, $isArray = false)
    {
        if($isArray){
            if(!is_array($newFilename))
                $newFilename = CJSON::decode($newFilename);
            if($oldFilename)
                foreach($oldFilename as $key => $filename){
                    $nKey = array_search($filename, $newFilename);
                    if($nKey === false)
                        $this->remove($filename, true);
                    else
                        unset($newFilename[$nKey]);
                }
            if($newFilename)
                foreach($newFilename as $filename){
                    @rename($this->normalizePath($newFilePath) . $filename, $this->getPath() . $filename);
                    $this->add($filename);
                }
        }else{
            if($oldFilename != $newFilename){
                if(file_exists($this->normalizePath($newFilePath) . $newFilename))
                    @rename($this->normalizePath($newFilePath) . $newFilename, $this->getPath() . $newFilename);
                $this->replace($oldFilename, $newFilename);
            }
        }
    }

    /**
     * Add Several Files in one place to stored files array
     * @param array $files
     */
    public function addFiles($files = [])
    {
        if($files){
            if(is_array($files))
                foreach($files as $file)
                    $this->add($file);
            else
                $this->add($files);
        }
    }

    /**
     * Returns Stored Files structured array
     * @return array
     */
    public function getFiles()
    {
        return $this->_storedFiles;
    }

    public function move($destinationPath, $fileName = false)
    {
        if($fileName)
            $this->moveFile($destinationPath, $fileName);
        else
            foreach($this->getFiles() as $file)
                $this->moveFile($destinationPath, $file['serverName']);
    }

    public function moveFile($destinationPath, $fileName)
    {
        if(file_exists($this->_path . $fileName))
            @rename($this->_path . $fileName, $this->normalizePath($destinationPath) . $fileName);
        $index = $this->exists($fileName);
        if($index !== false)
            unset($this->_storedFiles[$index]);
    }

    public function normalizePath($path)
    {
        if(!is_dir(Yii::getPathOfAlias('webroot') . DIRECTORY_SEPARATOR . $path))
            mkdir(Yii::getPathOfAlias('webroot') . DIRECTORY_SEPARATOR . $path, 0777, true);
        return Yii::getPathOfAlias('webroot') . DIRECTORY_SEPARATOR . $path . DIRECTORY_SEPARATOR;
    }

    public function normalizeUrl($path)
    {
        return Yii::app()->getBaseUrl(true) . '/' . $path . '/';
    }
}
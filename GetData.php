<?PHP
class GetData{
    public function read($csv){
        $file = fopen($csv, 'r');
        $i =0;
        while (!feof($file) && $i<20) {
            $line[] = fgetcsv($file, 1024);
            $i++;
        }
        fclose($file);
        return $line;
    }
}


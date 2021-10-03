<?PHP
class GetData{
    /* dans line :
      0 => string 'Date of the game' (length=16)
      1 => string 'Leagues' (length=7)
      2 => string 'Final Scores' (length=12)
      3 => string '' (length=0)
      4 => string '' (length=0)
      5 => string '1' (length=1)
      6 => string '1' (length=1)
      7 => string 'diff' (length=4)
      8 => string 'X' (length=1)
      9 => string 'X' (length=1)
      10 => string 'diff' (length=4)
      11 => string '2' (length=1)
      12 => string '2' (length=1)
      13 => string 'diff' (length=4)
      */
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


<?php


class Upload{
 
    public function upload_image($file){
         
        $target_dir="upload/images";
        if(!file_exists($target_dir)){
            mkdir($target_dir,0777,true);
        }
        $f_name = $file['name'];
        $f_tmp  = $file['tmp_name'];
        // $nameofimage = rand().'_'.time().".jpeg";
        $f_extension = explode('.', $f_name); //explode() convert string into array form.
        $f_extension = strtolower(end($f_extension)); // end() show the last index result of array.
        $f_newfile = rand().'_'.time().".".$f_extension;

        $target_dir=$target_dir."/".$f_newfile;

        if($f_extension == 'jpg' || $f_extension == 'png' || $f_extension == 'jpeg' )
        {
            if(move_uploaded_file($f_tmp,$target_dir))
            {
                
                return [
                    "Message"=>$f_newfile,
                    "Status"=>"OK"
                ];
              
            }
            else{
                return [
                    "Message"=>"BadHappened",
                    "Status"=>"Error"
                ];
            }
        }
        else{
            return [
                    "Message"=>"Invalid File Formate",
                    "Status"=>"Error"
                ];
        }
        
    }
}
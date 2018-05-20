<?php



if(isset($_POST['cmd'])){
$choice=$_POST['cmd'];

if ($choice == "j48"){
//echo $choice;	
//exec("Rscript credibility.r $assigID");

	$se=shell_exec('C:\ProgramData\Anaconda3\R\bin\R.exe  --vanilla <D:\Rtest.R'); 
		//$se=exec('C:\ProgramData\Anaconda3\R\bin\R.exe  --vanilla <D:\Rtest.R',$info); 
//var_dump($u);
//var_dump($return);

var_dump($se);
/*if($se==0){ 
    sleep(2); 
    echo "分析成功 ".$se.'</br>';
}else{ 
    echo "分析失败 ".$se; 
} */


}

}
?>

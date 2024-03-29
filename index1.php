<?php

if(!empty($_POST)){
     $name = $_POST['name'];


     if( preg_match('/^[0-9]+/', $_POST['name'])){
          echo "dont start with numbers!: " . $name;
     }else{
          echo "name is good: " . $name;
     }
}











?>


<form action="" method="post">
     <input name="name" type="text" placeholder="name">
     <button type="submit">Submit</button>
</form>
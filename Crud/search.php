<?php
require_once "../config.php";
if(isset($_POST["search_keyword"]) && isset($_POST["search_field"])){
    $search_keyword=$_POST["search_keyword"];
    $search_field=$_POST["search_field"];
    echo $search_keyword, $search_field;
    if ($search_field=="first_name"){
        $sql="SELECT * FROM persons WHERE first_name LIKE '%".$search_keyword."%'";
        $result=mysqli_query($conn,$sql);
    }elseif ($search_field=="last_name"){
        $sql="SELECT * FROM persons WHERE last_name LIKE '%".$search_keyword."%'";
        $result=mysqli_query($conn,$sql);
    }elseif ($search_field=="email"){
        $sql="SELECT * FROM persons WHERE email LIKE '%".$search_keyword."%'";
        $result=mysqli_query($conn,$sql);
    }
}
?>
<html>
<head><title>Retrieve</title></head>
<body>
<a href="create.php">Create</a>
<form action="search.php" method="post">
    <input type ="text" name="search_keyword" required>
    <select name="search_field" required>
        <option vavle ="first_name" selected> first Name</option>
        <option vavle ="last_name" selected>Last Name</option>
        <option vavle ="email" selected> email</option>
    </select>
    <input type ="submit" valve="search">

</form>
<a href="retrieve_to.php">Button<Clear></a>
<table border="1">
    <tr>
        <th>id</th>
        <th>Image</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Email</th>
        <th>Edit</th>
        <th>Delete</th>
    </tr>
       <?php
       if (isset($result)){
           if(mysqli_num_rows($result) == 0){
               echo"<tr>";
               echo"<td colspan='7'>No data found</td>";
               echo"</td";
           }
       }
       ?>
    <?php if(isset($result)) { ?>
    <?php foreach ($result as $row){ ?>
    <tr>
        <td><?php echo$row['id']?></td>
        <td><img src="upload/<?php echo $row['image']?>" height= "2%" width="5%"></td>
        <td><?php echo $row['first_name']?></td>
        <td><?php echo $row['last_name']?></td>
        <td><?php echo $row['email']?></td>
        <td><a href="update_details.php"?id=<?php echo $row["id"]?>">Edit</a></td>
            <td><a href="delete_details.php? id=<?php echo $row["id"]?>">Delete</a> </td>
        </tr>
    <?php } ?>
    <?php } ?>
</table>
</body>
</html>
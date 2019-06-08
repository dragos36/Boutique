<?php
require_once '../core/init.php';
if(!is_logged_in()){
  login_error_redirect();
}
include 'includes/head.php';
include 'includes/navigation.php';
//get brands from database
$sql="SELECT * FROM brand ORDER BY brand";
$results=$db->query($sql);
$errors=array();
//edit brands
if(isset($_GET['edit']) && !empty($_GET['edit'])){
  $edit_id = (int)$_GET['edit'];
  $edit_id = sanitize($edit_id);
  $sql2 = "SELECT * FROM brand WHERE id = '$edit_id'";
  $edit_result = $db->query($sql2);
  $eBrand = mysqli_fetch_assoc($edit_result);
}

//delete brands
if(isset($_GET['delete']) && !empty($_GET['delete'])){
  $delete_id = (int)$_GET['delete'];
  $delete_id = sanitize($delete_id);
  $sql = "DELETE FROM brand WHERE id='$delete_id'";
  $db->query($sql);
  header('Location: brands.php');//this is to refresh the page after delete a brand and see that page without the deleted brand

}
//if add form is submitted
if(isset($_POST['add_submit'])){//that means if the button submit was pressed what is gonna happen with all the data ?
  $brand =sanitize($_POST['brand']);//wrap what user is inserting in sanitize function which is defined in helpers page for security purposes
  //check if brand is blank
  if($_POST['brand'] == ''){
    $errors[] .=  'You must enter a brand!';
  }
  //check if brand exist in Database
  $sql = "SELECT * FROM brand WHERE brand = '$brand'";//this is checking if the brand already exist in the database
  if(isset($_GET['edit'])){
    $sql = "SELECT * FROM brand WHERE brand = '$brand' AND id != '$edit_id'";//why is this need for ????????????????????????????
  }
  $result = $db->query($sql);
  $count = mysqli_num_rows($result);
  if($count > 0){
      $errors[] .= $brand.' already exists. Please choose another brand name';
  }
  //display errors
  if(!empty($errors)){
    echo display_errors($errors);
  }else{
    //Add brand to Database
    $sql = "INSERT INTO brand (brand) VALUES ('$brand')";//insert into table brand in the brand column...
    if(isset($_GET['edit'])){
      $sql = "UPDATE brand SET brand = '$brand' WHERE id = '$edit_id'";
    }
    $db->query($sql);
    header('Location: brands.php');//this is for refresh the page and see the new added brand
  }
}
 ?>

<h2 class="text-center">Brands</h2><hr>
<!--Brand Form-->
<div class="text-center">
  <form class="form-inline" action="brands.php<?=((isset($_GET['edit']))?'?edit='.$edit_id:''); ?>" method="post">
    <div class="form-group">
      <?php
      $brand_value='';
      if(isset($_GET['edit'])){
        $brand_value = $eBrand['brand'];
      }else{
        if(isset($_POST['brand'])){
          $brand_value = sanitize($_POST['brand']);
        }
      } ?>
      <label for="brand"><?=((isset($_GET['edit']))?'Edit':'Add a'); ?> Brand: </label>
      <input type="text" name="brand" id="brand" class="form-control" value="<?=$brand_value; ?>">
      <?php if(isset($_GET['edit'])): ?>
        <a href="brands.php" class="btn btn-default">Cancel</a>
      <?php endif; ?>
      <input type="submit" name="add_submit" value="<?=((isset($_GET['edit']))?'Edit':'Add'); ?> Brand" class="btn btn-success">
    </div>
  </form>
</div><hr>
<table class="table table-bordered table-striped table-auto table-condensed">
  <thead>
    <th></th>
    <th>Brand</th>
    <th></th>
  </thead>
  <tbody>
    <?php while($brand = mysqli_fetch_assoc($results)): ?>
      <tr>
        <td><a href="brands.php?edit=<?=$brand['id']; ?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-pencil"></span></a></td><!--this ?edit-1 is to see the id of the brands in the url-->
        <td><?=$brand['brand']; ?></td>
        <td><a href="brands.php?delete=<?=$brand['id']; ?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-remove-sign"></span></a></td>
      </tr>
  <?php endwhile; ?>
  </tbody>
</table>
<?php
include 'includes/footer.php';
 ?>

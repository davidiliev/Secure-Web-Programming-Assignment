// IDEA for error display https://codewithawa.com/posts/complete-user-registration-system-using-php-and-mysql-database

<?php  if (count($errors) > 0) : ?>
<style> 
.error{
color:red;
}
</style>
  <div class="error">
  	<?php foreach ($errors as $error) : ?>
  	  <p><?php echo $error ?></p>
  	<?php endforeach ?>
  </div>
<?php  endif ?>
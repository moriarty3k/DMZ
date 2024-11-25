 

<p>

    Subcribe để nhận thông báo mới nhất.
    <form method='post' action=''>
        <div class="form-group"> 
            <input placeholder="Điền email của bạn (admin@example.com)" name="email" type="email" size=50></input> <button class="btn btn-default" type="submit" name='submit'>Submit</button>
       </div> 
    </form>

<?php
include('vendor/twig/twig/lib/Twig/Autoloader.php');
if (isset($_POST['email'])) {
    $email=$_POST['email'];

    Twig_Autoloader::register();
    try {
        $loader = new Twig_Loader_String();
        $twig = new Twig_Environment($loader);

        $result= $twig->render("Chào mừng {$email}. Chúng tôi sẽ liên hệ lại trong thời gian sớm nhất.");
        echo $result;

    } catch (Exception $e) {
        echo $e->getMessage();
    }
}

?>
</p>
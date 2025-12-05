<?php
echo "<pre></pre>";
print_r($_POST);
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name    = htmlspecialchars(trim($_POST["name"]));
    $email   = htmlspecialchars(trim($_POST["email"]));
    $phone   = htmlspecialchars(trim($_POST["phone"]));
    $message = htmlspecialchars(trim($_POST["message"]));

    // $to = "v4vikram.dev@gmail.com, vikash.stratvice@gmail.com, stratvice@gmail.com";
    $to = "v4vikram.dev@gmail.com";
    $subject = "New Contact Form Message";

    $body = "Name: $name\nEmail: $email\nPhone: $phone\nMessage:\n$message";

    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    if (mail($to, $subject, $body, $headers)) {
        echo "success";
    } else {
        echo "error";
    }
} else {
    echo "invalid";
}
?>


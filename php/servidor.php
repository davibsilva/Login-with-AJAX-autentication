<?php
require "comum.php";
$login    = $_POST['login'];
$password = $_POST['password']; // pegando dados do formulário
$code     = $_POST['code'];

$queryUser = "SELECT * FROM user WHERE login = '$login' AND password = '$password'";
$result = mysqli_query($conn, $queryUser);
$numRow = mysqli_num_rows($result);
$row = mysqli_fetch_assoc($result);

$queryEmail = "SELECT * FROM user WHERE email = '$login' AND password = '$password'";
$resultEmail = mysqli_query($conn, $queryEmail);
$numRowEmail = mysqli_num_rows($resultEmail);
$rowEmail = mysqli_fetch_assoc($resultEmail);

$randomCode = rand(1000, 9999);
$insertCodeQuery = "UPDATE user SET twoFactorCode = '$randomCode'";

// Se o usuário não tiver twoFactor
$valid = false; // declarando a variável valid para ser usada a frente
if ($login){ //Se o login não for vazio, fazer:
    if($row['login'] == $login && $row['password'] == $password) { //Verificando se login digitado está no banco
        $valid = true; // Se o login estiver no banco, validar
        $twoFactor = $row['twoFactor']; // Pegando o valor de twoFactor no banco, sendo null ou não
    }else if ($rowEmail['email'] == $login && $rowEmail['password'] == $password) { //Verificando caso o usuário digitar um email
        $valid = true;// Se o email digitado estiver no banco, validar
        $twoFactor = $rowEmail['twoFactor']; // Nesse caso o twoFactor não será null
    }
}
$validationCode = null; // Variável verifica código de validacao
if ($valid) { //se valid for igual a true
    $message = '<span>Login efetuado com sucesso!</span>';

    if($twoFactor) { // Se twoFactor tive um valor executa:

        if($code === '') { // Quando a tela carregar será executado pois só terá o campo
            mysqli_query($conn, $insertCodeQuery);
            $message = "<span> Insira o código enviado ao seu email</span>";
        } else if($code != $rowEmail['twoFactorCode']) { // Se o código for diferente do banco executa:
            header('HTTP/1.1 200');
            $message = "<span style='background-color: #fff5f5 ; color: #ff6b6b; border-radius: 5px; width: 100%;'> Código inválido, insira o código enviado em seu e-mail</span>";
            $validationCode = false;
        } else if($code == $rowEmail['twoFactorCode']) { // Se o código for igual ao banco executa:
            header('HTTP/1.1 200');
            $validationCode = true;
            $message = "<span> Login efetuado com sucesso!</span>";
        }
    }

    header('HTTP/1.1 200');
    //Abaixo será executado se twoFactor for nulo
    $response = array('status' => 'success', 'message' => $message, 'twoFactor' => $twoFactor, 'validationCode' => $validationCode, 'randomCode' => $randomCode, 'password' => $password);
} else {
    // Se bater no if($valid) e não corresponder a condição, virá direto pra cá
    header('HTTP/1.1 500');
    $response = array('status' => 'failure', 'message' => '<span>Login ou senha inválidos</span>');
}

//enviando a response ao cliente em formato json;
header('Content-Type: application/json');
echo json_encode($response);
?>
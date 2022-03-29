<?php
    include_once 'config.php';

    $name = $_POST['name'];
    $email = $_POST['email'];
    $cep = $_POST['cep'];

    if(isset($_POST['submit']))
    {   
        //Inserindo valores no localhost/phpmyadmin.
        //banco de dados: PHPtest - tabela: ConsultaCep - Valores: (varchars).
        $Verification = "SELECT * FROM ConsultaCep WHERE cep = '$cep'";
        $resVerification = $conect->query($Verification);

        //Registrando novo cep inexistente na tabela.
        if(mysqli_num_rows($resVerification) < 1)
        {
            $xmlTest = simplexml_load_file("https://viacep.com.br/ws/{$cep}/xml/");

            $i = 0;

            foreach($xmlTest as $tag => $value)
            {
                $indice[$i] = $value;
                $TagIndx[$i] = $tag;
                if($indice[$i] == ""){$indice[$i] = "Não informado";}
                $i += 1;
            }

            $cep = $indice[0];
            $logradouro  = $indice[1];
            $complemento = $indice[2];
            $bairro = $indice[3];
            $localidade = $indice[4];
            $uf = $indice[5];
            $ibge = $indice[6];
            $gia = $indice[7];
            $ddd = $indice[8];
            $siafi = $indice[9];

            $result = mysqli_query($conect, "INSERT INTO ConsultaCep(cep, logradouro, complemento, bairro, localidade, uf, ibge, gia, ddd, siafi) VALUES('$cep', '$logradouro', '$complemento', '$bairro', '$localidade', '$uf', '$ibge', '$gia', '$ddd', '$siafi')");
            
            $exist = false;
        }
        else
        {
            $select = "SELECT * FROM ConsultaCep WHERE cep = '$cep'";

            $result = $conect->query($select);


            $select_data = mysqli_fetch_assoc($result);

            $logradouro = $select_data['logradouro'];
            $complemento = $select_data['complemento']; 
            $bairro = $select_data['bairro'];
            $localidade = $select_data['localidade'];
            $uf = $select_data['uf'];
            $ibge = $select_data['ibge'];
            $gia = $select_data['gia'];
            $ddd = $select_data['ddd'];
            $siafi = $select_data['siafi'];
            
            $exist = true;
        }
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>PHP - test</title>
</head>
<body>
    <header>
        <h1>Teste de PHP</h1>
    </header>

    <main style="display: flex;"> 
        <div class="formulary rounded">
            <form action="." method = "post">
                <div class="mb-3">
                    <label for="nameLabel" class="form-label">Nome</label>
                    <input type="text" class="form-control" id="name" aria-describedby="name" name="name" required>

                    <label for="exampleInputEmail1" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email" required>
                    <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>

                    <label for="cepLabel" class="form-label mt-3">CEP</label>
                    <input type="text" class="form-control" id="cep" name="cep" aria-describedby="cep" placeholder="12345-678" onblur="getCep()" required>
                </div>
                <input type="submit" value="submit" name="submit">
            </form>
        </div>

        <div class="forms-answers p-2" style="position: absolute; right: 20px; max-width: 700px; box-shadow: 2px 2px 6px 1px rgb(129, 129, 129)">
            <h1><?php echo "Name: $name"; ?></h1>
            <h1><?php echo "email: $email"; ?></h1>
            <h1><?php for($i = 0; $i <= 10; $i++){if($indice[$i] != ""){echo "$TagIndx[$i]: $indice[$i]"."<br>";}}?></h1>
            <h1><?php if($exist){echo "CEP: $cep<br>"."Logradouro: $logradouro<br>". "Complemento: $complemento<br>" ."Bairro: $bairro<br>"."Localidade: $localidade<br>"."UF: $uf<br>"."IBGE: $ibge<br>"."gia: $gia<br>"."DDD: $ddd<br>"."siafi: $siafi<br>"; }?></h1>
        </div>
    </main>
    <script src="./script.js"></script>
</body>
</html>